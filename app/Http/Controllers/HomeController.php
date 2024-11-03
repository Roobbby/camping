<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camping;
use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index()
    {
        $campingItems = Camping::all();
        return view('front.index', compact('campingItems'));
    }

    public function tools(Request $request)
    {
        $query = $request->input('search');

        if ($query) {
            $items = Camping::where('name', 'LIKE', "%{$query}%")
                ->paginate(6);
        } else {
            $items = Camping::paginate(6);
        }

        return view('front.tool', compact('items'));
    }

    public function showForm()
    {
        $profileData = User::where('phone')->first();
        return view('front.recomend', compact('profileData'));
    }

    public function recomend(Request $request)
    {
        $request->validate([
            'number_of_people' => 'required|integer|min:1',
            'terrain' => 'required|string',
            'budget' => 'required|numeric',
            'number_of_days' => 'required|integer|min:1',
        ]);

        $numberOfPeople = $request->input('number_of_people');
        $terrain = $request->input('terrain');
        $budget = $request->input('budget');
        $numberOfDays = $request->input('number_of_days');

        $queryDescription = $this->generateQueryDescription($numberOfPeople, $terrain, $budget, $numberOfDays);

        $equipment = Camping::all(['id', 'name', 'description', 'price']);
        $descriptions = $equipment->pluck('description', 'id')->toArray();
        $names = $equipment->pluck('name', 'id')->toArray();
        $prices = $equipment->pluck('price', 'id')->toArray();

        $recommendations = $this->calculateRecommendations($descriptions, $numberOfPeople, $terrain, $budget, $numberOfDays);

        $tentIncluded = false;
        $totalPrice = 0;
        $finalRecommendations = collect();

        foreach ($recommendations as $id => $score) {
            if (!isset($names[$id]) || !isset($prices[$id])) {
                continue;
            }

            $description = $descriptions[$id];

            if (strpos(strtolower($description), 'tenda') !== false) {
                $capacity = $this->getTentCapacity($description);
                $quantity = ceil($numberOfPeople / $capacity);
                $subtotal = $prices[$id] * $quantity * $numberOfDays;

                if ($subtotal <= $budget) {
                    $totalPrice += $subtotal;
                    $tentIncluded = true;

                    $this->addToRecommendations($finalRecommendations, $id, $names[$id], $prices[$id], $quantity, $subtotal, $score);
                    break;
                }
            }
        }

        if (!$tentIncluded) {
            $tents = $equipment->filter(function($item) {
                return strpos(strtolower($item->description), 'tenda') !== false;
            });

            if ($tents->isNotEmpty()) {
                $defaultTent = $tents->sortBy('price')->first();
                if ($defaultTent) {
                    $capacity = $this->getTentCapacity($defaultTent->description);
                    $quantity = ceil($numberOfPeople / $capacity);
                    $subtotal = $defaultTent->price * $quantity * $numberOfDays;

                    if ($subtotal <= $budget) {
                        $totalPrice += $subtotal;
                        $tentIncluded = true;

                        $this->addToRecommendations($finalRecommendations, $defaultTent->id, $defaultTent->name, $defaultTent->price, $quantity, $subtotal, 0);
                    } else {
                        $defaultTent = $tents->sortByDesc(function($item) {
                            return $this->getTentCapacity($item->description);
                        })->first();

                        if ($defaultTent) {
                            $capacity = $this->getTentCapacity($defaultTent->description);
                            $quantity = ceil($numberOfPeople / $capacity);
                            $subtotal = $defaultTent->price * $quantity * $numberOfDays;

                            if ($subtotal <= $budget) {
                                $totalPrice += $subtotal;
                                $tentIncluded = true;

                                $this->addToRecommendations($finalRecommendations, $defaultTent->id, $defaultTent->name, $defaultTent->price, $quantity, $subtotal, 0);
                            }
                        }
                    }
                }
            }
        }

        if ($tentIncluded) {
            $remainingBudget = $budget - $totalPrice;

            if ($remainingBudget > 0) {
                foreach ($recommendations as $id => $score) {
                    if (!isset($names[$id]) || !isset($prices[$id])) {
                        continue;
                    }

                    $description = $descriptions[$id];

                    if (strpos(strtolower($description), 'tenda') !== false) {
                        continue;
                    }

                    $quantity = $this->calculateQuantityNeeded($description, $numberOfPeople);
                    $subtotal = $prices[$id] * $quantity * $numberOfDays;

                    if ($subtotal > $remainingBudget) {
                        continue;
                    }

                    $totalPrice += $subtotal;
                    $remainingBudget -= $subtotal;

                    $this->addToRecommendations($finalRecommendations, $id, $names[$id], $prices[$id], $quantity, $subtotal, $score);

                    if ($remainingBudget <= 0) {
                        break;
                    }
                }
            }
        }

        if (!$tentIncluded) {
            $tents = $equipment->filter(function($item) {
                return strpos(strtolower($item->description), 'tenda') !== false;
            });

            if ($tents->isNotEmpty()) {
                $defaultTent = $tents->sortBy('price')->first();
                if ($defaultTent) {
                    $capacity = $this->getTentCapacity($defaultTent->description);
                    $quantity = ceil($numberOfPeople / $capacity);
                    $subtotal = $defaultTent->price * $quantity * $numberOfDays;

                    if ($subtotal <= $budget) {
                        $finalRecommendations->push([
                            'id' => $defaultTent->id,
                            'name' => $defaultTent->name,
                            'price' => $defaultTent->price,
                            'quantity' => $quantity,
                            'subtotal' => $subtotal,
                            'score' => 0,
                        ]);
                        $totalPrice += $subtotal;
                    } else {
                        return redirect()->back()->with('error', 'Budget Anda terlalu kecil untuk menyertakan tenda yang sesuai.');
                    }
                }
            }
        }
        $recommendedIds = $finalRecommendations->pluck('id')->toArray();
        $additionalEquipment = $equipment->filter(function ($item) use ($recommendedIds) {
            return !in_array($item->id, $recommendedIds);
        });
        session(['recommendations' => $finalRecommendations]);
        // dd($finalRecommendations);
        $profileData = User::whereNotNull('phone')->first();
        return view('front.recomend_result', [
            'recommendations' => $finalRecommendations,
            'total_price' => $totalPrice,
            'number_of_people' => $numberOfPeople,
            'terrain' => $terrain,
            'budget' => $budget,
            'number_of_days' => $numberOfDays,
            'profileData' => $profileData,
            'queryDescription'=> $queryDescription,
            'additionalEquipment' => $additionalEquipment,
        ]);
    }

    public function showRecommendationResult()
    {
        $queryDescription = session('queryDescription', '');
        $recommendations = session('recommendations', collect());
        $totalPrice = session('total_price', 0);
        $numberOfPeople = session('number_of_people', 0);
        $terrain = session('terrain', '');
        $budget = session('budget', 0);
        $numberOfDays = session('number_of_days', 0);
        $profileData = User::whereNotNull('phone')->first();
        $additionalEquipment = Camping::whereNotIn('id', $recommendations->pluck('id'))->get();
        // dd($recommendations);

        return view('front.recomend_result', [
            'queryDescription' => $queryDescription,
            'recommendations' => $recommendations,
            'total_price' => $totalPrice,
            'number_of_people' => $numberOfPeople,
            'terrain' => $terrain,
            'budget' => $budget,
            'number_of_days' => $numberOfDays,
            'profileData' => $profileData,
            'additionalEquipment' => $additionalEquipment,
        ]);
    }

    public function saveRecommendation(Request $request)
    {
        // $request->validate([
        //     'renter_name' => 'required|string|max:255',
        //     'items' => 'required|array',
        //     'items.*.id' => 'required|integer',
        //     'items.*.quantity' => 'required|integer|min:1',
        //     'items.*.price' => 'required|numeric|min:0',
        // ]);

        $request->validate([
            'renter_name' => 'string|max:255',
            'items' => 'array',
            'items.*.id' => 'integer',
            'items.*.quantity' => 'integer|min:1',
            'items.*.price' => 'numeric|min:0',
        ]);

        $updatedItems = collect($request->input('items', []));
        // dd($request->all());

        if ($updatedItems->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada rekomendasi untuk disimpan.');
        }

        $totalPrice = 0;
        $itemsForWhatsApp = '';
        foreach ($updatedItems as $item) {
            if (isset($item['quantity']) && isset($item['price']) && isset($item['id'])) {
                $quantity = intval($item['quantity']);
                $price = floatval($item['price']);
                $subtotal = $quantity * $price;

                $totalPrice += $subtotal;

                $itemData = Camping::find($item['id']);
                $itemName = $itemData ? $itemData->name : 'Item Tidak Dikenal';
                $itemsForWhatsApp .= "- $itemName: $quantity pcs \n";
                // dd($item);
            } else {
                return redirect()->back()->with('error', 'Format item tidak valid.');
            }
        }

        $recommendation = Recommendation::create([
            'renter_name' => $request->input('renter_name'),
            'total_price' => $totalPrice,
        ]);

        foreach ($updatedItems as $item) {
            if (isset($item['id'])) {
                $recommendation->recommendedItems()->create([
                    'camping_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'subtotal_price' => $item['quantity'] * $item['price'],
                ]);
            }
        }

        $phone = $request->input('phone');
        $renterName = $request->input('renter_name');
        $message = "Hai, Saya $renterName ingin menyewa barang-barang ini:\n$itemsForWhatsApp\nMohon info lebih lanjut.";
        $encodedMessage = urlencode($message);

        return redirect("https://api.whatsapp.com/send?phone=+62$phone&text=$encodedMessage")
            ->with('success', 'Rekomendasi berhasil disimpan!');
    }


    // dd($request->all());
    private function addToRecommendations($collection, $id, $name, $price, $quantity, $subtotal, $score)
    {
        $collection->push([
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
            'score' => $score,
        ]);
    }

    private function getTentCapacity($description)
    {
        if (strpos($description, '1-2 orang') !== false) return 2;
        if (strpos($description, '3-4 orang') !== false) return 4;
        if (strpos($description, '5-6 orang') !== false) return 6;
        return 6;
    }


    private function calculateRecommendations($descriptions, $numberOfPeople, $terrain, $budget, $numberOfDays)
    {
        $queryDescription = $this->generateQueryDescription($numberOfPeople, $terrain, $budget, $numberOfDays);
        $descriptionsArray = array_values($descriptions);
        $queryIndex = count($descriptionsArray);

        $descriptionsArray[] = $queryDescription;
        $tokenized = $this->tokenize($descriptionsArray);

        $tfidf = $this->computeTfIdf($tokenized);

        $cosineSimilarities = $this->computeCosineSimilarity($tfidf, $queryIndex);

        $descriptions = array_values($descriptions);

        $tentScores = [];
        $otherScores = [];

        foreach ($cosineSimilarities as $id => $score) {
            if (isset($descriptions[$id]) && str_contains(strtolower($descriptions[$id]), 'tenda')) {
                $tentScores[$id] = $score;
            } else {
                $otherScores[$id] = $score;
            }
        }

        arsort($tentScores);
        arsort($otherScores);

        return collect($tentScores + $otherScores);
    }

    private function calculateQuantityNeeded($description, $numberOfPeople)
    {
        if (strpos(strtolower($description), 'tenda') !== false) {
            if (preg_match('/(\d+)-(\d+) orang/i', $description, $matches)) {
                $minCapacity = (int)$matches[1];
                $maxCapacity = (int)$matches[2];
                $averageCapacity = ($minCapacity + $maxCapacity) / 2;
                return ceil($numberOfPeople / $averageCapacity);
            }
        } else {
            if (strpos(strtolower($description), 'matras') !== false || strpos(strtolower($description), 'sleeping bag') !== false) {
                return $numberOfPeople;
            }
        }

        return 1;
    }

    private function generateQueryDescription($numberOfPeople, $terrain, $budget, $numberOfDays)
    {
        return "Berkemah dengan Jumlah $numberOfPeople orang, serta medan yang ditempuh $terrain, jumlah anggaran $budget, untuk $numberOfDays Hari ";
    }

    private function tokenize($texts)
    {
        $stopwords = ["dan", "yang", "di", "untuk", "dari", "dengan", "adalah", "ini", "itu",
                    "pada", "tidak", "juga", "oleh", "telah", "sangat", "antara", "dalam",
                    "per", "serta", "saat", "dapat", "ke", "sebagai", "ada", "karena",
                    "maka", "atau", "bagi", "lebih", "agar", "sehingga", "bahwa", "tersebut",
                    "seperti", "lain", "hal", "ia", "sudah", "masih", "hanya", "baik",
                    "mereka", "bisa", "akan", "menjadi", "tetapi", "pula", "jika", "jadi",
                    "maupun", "misalnya", "setelah", "secara", "sampai", "apabila", "namun"];
        $tokenized = [];

        foreach ($texts as $text) {
            $text = strtolower($text);
            $text = preg_replace('/[^a-z0-9\s]/', '', $text);
            $words = explode(' ', $text);
            $words = array_diff($words, $stopwords);
            $tokenized[] = array_count_values($words);
        }

        return $tokenized;
    }

    private function computeTfIdf($tokenized)
    {
        $tfidf = [];
        $numDocs = count($tokenized);
        $docWords = array_map('array_keys', $tokenized);
        $allWords = array_unique(array_merge(...$docWords));

        foreach ($tokenized as $index => $doc) {
            $tfidf[$index] = [];
            $docLength = array_sum($doc);
            foreach ($allWords as $word) {
                $tf = isset($doc[$word]) ? $doc[$word] / $docLength : 0;
                $df = array_reduce($tokenized, function ($carry, $doc) use ($word) {
                    return $carry + (isset($doc[$word]) ? 1 : 0);
                }, 0);
                $idf = $df > 0 ? log($numDocs / $df) : 0;
                $tfidf[$index][$word] = $tf * $idf;
            }
        }

        return $tfidf;
    }

    private function computeCosineSimilarity($tfidf, $queryIndex)
    {
        $queryVector = $tfidf[$queryIndex];
        unset($tfidf[$queryIndex]);
        $similarities = [];

        foreach ($tfidf as $docIndex => $docVector) {
            $dotProduct = 0;
            $queryNorm = 0;
            $docNorm = 0;

            foreach ($queryVector as $word => $weight) {
                $dotProduct += $weight * ($docVector[$word] ?? 0);
                $queryNorm += $weight ** 2;
            }

            foreach ($docVector as $weight) {
                $docNorm += $weight ** 2;
            }

            $queryNorm = sqrt($queryNorm);
            $docNorm = sqrt($docNorm);

            $cosineSimilarity = $docNorm > 0 && $queryNorm > 0 ? $dotProduct / ($queryNorm * $docNorm) : 0;
            $similarities[$docIndex] = $cosineSimilarity;
        }

        return $similarities;
    }

}
