@extends('front.layout.landing_page')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Rekomendasi')
@section('content')

<section class="container mb-5">
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <!-- Header and Form -->
    <nav class="pt-4 mt-lg-3" aria-label="breadcrumb"></nav>
    <div class="py-4 mt-lg-2 mb-1">
        <h1 class="me-3 mt-2">Halaman Hasil Rekomendasi</h1>
        <h3 class="me-3 mt-2">Berikut Hasil Rekomendasi yang sesuai dengan preferensi Anda</h3>
        {{-- query penyewa --}}
        @if(isset($queryDescription))
        <div class="alert alert-info mt-4">
            <p style="font-size: 18px;">{{ $queryDescription }}</p>
        </div>
        @endif
    </div>

    {{-- hasil rekomendasi --}}
    @if(isset($recommendations) && $recommendations->count() > 0)

    <div class="modal fade" id="additionalEquipmentModal" tabindex="-1" aria-labelledby="additionalEquipmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title" id="additionalEquipmentModalLabel">Tambah Alat Jika Kurang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="additionalEquipmentForm">
                        <div class="mb-3">
                            <label for="equipment-select" class="form-label">Pilih Alat Tambahan:</label>
                            <select class="form-select" id="equipment-select" name="equipment">
                                @foreach($additionalEquipment as $equipment)
                                    <option value="{{ $equipment->id }}" data-name="{{ $equipment->name }}" data-price="{{ $equipment->price }}">
                                        {{ $equipment->name }} - Rp {{ number_format($equipment->price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambahkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title">Rekomendasi Terbaik</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#additionalEquipmentModal">
                    Tambah Alat Jika Kurang
                </button>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Pilih</th>
                        <th>Nama Barang</th>
                        <th>Harga Sewa Per Item</th>
                        <th>Jumlah Item</th>
                        <th>Sub Total Harga Per Item</th>
                        <th>Skor Cosine Similarity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recommendations as $index => $recommendation)
                    <tr>
                            {{-- {{ $recommendation['id'] }} --}}
                            <input type="hidden" class="item-id" value="{{ $recommendation['id'] }}">

                        <td>
                            <input type="checkbox" class="item-select" data-index="{{ $index }}" checked style="width: 24px; height: 24px; cursor: pointer;">
                        </td>
                        <td>{{ $recommendation['name'] }}</td>
                        {{-- <td> {{ $recommendation['id'] }}</td> --}}
                        <td>Rp {{ number_format($recommendation['price'], 0, ',', '.') }}</td>
                        <td>
                            <input type="number"
                                    id="quantity-{{ $index }}"
                                    data-index="{{ $index }}"
                                    value="{{ $recommendation['quantity'] }}"
                                    min="1"
                                    style="width: 80px; height: 40px; font-size: 18px; padding: 5px; border: 2px solid #d1d9e0; border-radius: 5px;">
                        </td>
                        <td class="item-subtotal" id="subtotal-{{ $index }}" data-index="{{ $index }}" data-price="{{ $recommendation['price'] }}">
                            Rp {{ number_format($recommendation['subtotal'], 0, ',', '.') }}
                        </td>
                        <td>{{ number_format($recommendation['score'], 4) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                <h5>Total Harga Semua Item: Rp <span id="total-price">{{ number_format($total_price, 0, ',', '.') }}</span></h5>
            </div>

            <div class="mt-4">
                <h5>Masukkan Nama Penyewa:</h5>
                <input type="text" class="form-control" id="renter-name" name="renter_name" placeholder="Nama Anda" required>
            </div>
            <form id="whatsappForm" action="{{ route('save.recommendation') }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="phone" value="{{ $profileData->phone }}">
                <input type="hidden" name="whatsapp_message" id="whatsappMessageInput">
                <input type="hidden" name="renter_name" id="hiddenRenterName">

                <button type="submit" class="btn btn-success mt-3" id="submitBtn" disabled>
                    Dapatkan Lewat WhatsApp
                </button>
            </form>
        </div>
    </div>

    @endif

</section>
<script>
  function updateTotalPrice() {
    let totalPrice = 0;

    document.querySelectorAll('.item-select').forEach((selectElement, i) => {
        if (selectElement.checked) {
            let quantity = parseInt(document.querySelector(`#quantity-${i}`).value);

            let price = parseInt(document.querySelector(`#subtotal-${i}`).getAttribute('data-price'));

            if (!isNaN(price) && !isNaN(quantity)) {
                let subtotal = quantity * price;

                // Update subtotal di tampilan
                document.querySelector(`#subtotal-${i}`).innerText = 'Rp ' + subtotal.toLocaleString('id-ID');

                totalPrice += subtotal;
            }
        }
    });

    document.getElementById('total-price').innerText = totalPrice.toLocaleString('id-ID');
}

function toggleSubmitButton() {
    const renterName = document.getElementById('renter-name').value.trim();
    const submitBtn = document.getElementById('submitBtn');

    if (renterName) {
        submitBtn.disabled = false;
    } else {
        submitBtn.disabled = true;
    }
}

document.querySelectorAll('input[type="number"]').forEach((inputElement) => {
    inputElement.addEventListener('input', function() {
        updateTotalPrice();
    });
});

document.querySelectorAll('.item-select').forEach((selectElement, i) => {
    selectElement.addEventListener('change', function() {
        let quantityInput = document.querySelector(`#quantity-${i}`);
        if (this.checked) {
            quantityInput.disabled = false;
            quantityInput.value = 1;
        } else {
            quantityInput.disabled = true;
            quantityInput.value = 0;
        }
        updateTotalPrice();
    });
});

document.getElementById('renter-name').addEventListener('input', toggleSubmitButton);

document.getElementById('whatsappForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    let renterName = document.getElementById('renter-name').value;
    console.log('Renter Name:', renterName);
    if (renterName) {
        // Set hidden input for whatsapp_message
        let whatsappMessage = `Nama Penyewa: ${renterName}\n\nDaftar Item:\n`;

        document.getElementById('hiddenRenterName').value = renterName;
        // Clear previous items data (if any)
        document.querySelectorAll('.hidden-item-input').forEach(input => input.remove());

        document.querySelectorAll('.item-select').forEach(function(checkbox, index) {
            if (checkbox.checked) {
                let row = checkbox.closest('tr');
                // let itemName = document.querySelectorAll('tbody tr')[index].querySelector('td:nth-child(2)').innerText;
                let itemName = row.querySelector('td:nth-child(3)').innerText;
                let itemId = document.querySelectorAll('.item-id')[index].value;
                let itemQuantity = document.querySelector(`#quantity-${index}`).value;
                let itemPrice = document.querySelector(`#subtotal-${index}`).getAttribute('data-price');
                let itemSubtotal = itemQuantity * itemPrice;

                whatsappMessage += `- ${itemName} (${itemQuantity} pcs) @ Rp ${itemPrice.toLocaleString('id-ID')} per item, Subtotal Rp ${itemSubtotal.toLocaleString('id-ID')}\n`;

                // Append hidden inputs to form
                let form = document.getElementById('whatsappForm');
                form.insertAdjacentHTML('beforeend', `
                    <input type="hidden" name="items[${index}][id]" value="${itemId}" class="hidden-item-input">
                    <input type="hidden" name="items[${index}][quantity]" value="${itemQuantity}" class="hidden-item-input">
                    <input type="hidden" name="items[${index}][price]" value="${itemPrice}" class="hidden-item-input">
                `);
            }
        });

        whatsappMessage += `\nTotal Harga: Rp ${document.getElementById('total-price').innerText}`;

        document.getElementById('whatsappMessageInput').value = whatsappMessage;
        console.log('WhatsApp Message:', whatsappMessage);
        this.submit();
    } else {
        alert('Nama penyewa harus diisi.');
    }
});


document.getElementById('additionalEquipmentForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let equipmentSelect = document.getElementById('equipment-select');
    let selectedOption = equipmentSelect.options[equipmentSelect.selectedIndex];
    let equipmentId = selectedOption.value;
    let equipmentName = selectedOption.getAttribute('data-name');
    let equipmentPrice = parseInt(selectedOption.getAttribute('data-price'));

    // Buat baris baru di tabel
    let newRow = document.createElement('tr');
    let index = document.querySelectorAll('.item-select').length;

    newRow.innerHTML = `
        <td>
            <input type="checkbox" class="item-select" data-index="${index}" checked style="width: 24px; height: 24px; cursor: pointer;">
            <input type="hidden" class="item-id" value="${equipmentId}">
        </td>
        <td>${equipmentName}</td>
        <td>Rp ${equipmentPrice.toLocaleString('id-ID')}</td>
        <td>
            <input type="number"
                id="quantity-${index}"
                data-index="${index}"
                value="1"
                min="1"
                style="width: 80px; height: 40px; font-size: 18px; padding: 5px; border: 2px solid #d1d9e0; border-radius: 5px;">
        </td>
        <td class="item-subtotal" id="subtotal-${index}" data-index="${index}" data-price="${equipmentPrice}">
            Rp ${equipmentPrice.toLocaleString('id-ID')}
        </td>
        <td>N/A</td>
    `;

    document.querySelector('tbody').appendChild(newRow);

    // Tambahkan event listener untuk quantity dan checkbox
    document.querySelector(`#quantity-${index}`).addEventListener('input', updateTotalPrice);

    document.querySelector(`.item-select[data-index="${index}"]`).addEventListener('change', function() {
        let quantityInput = document.querySelector(`#quantity-${index}`);
        if (this.checked) {
            quantityInput.disabled = false;
            quantityInput.value = 1;
        } else {
            quantityInput.disabled = true;
            quantityInput.value = 0;
        }
        updateTotalPrice();
    });

    updateTotalPrice();

    // Hapus opsi yang dipilih dari dropdown
    equipmentSelect.remove(equipmentSelect.selectedIndex);

    // Tutup modal
    let modal = bootstrap.Modal.getInstance(document.getElementById('additionalEquipmentModal'));
    modal.hide();
});



</script>
@endsection
