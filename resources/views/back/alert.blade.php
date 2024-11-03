@if (session('alert') === 'success')
    <div id="successAlert" class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-check-circle"></i>
        {{ session('message') }}
    </div>
@elseif (session('alert') === 'error')
    <div id="errorAlert" class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="fa fa-warning"></i>
        {{ session('message') }}
    </div>
@endif

@if($errors->has('name'))
    <div id="namealert" class="alert alert-danger alert-dismissible" role="alert">
        {{ $errors->first('name') }}
    </div>
@endif

<script>
    setTimeout(function() {
        document.getElementById('successAlert').style.display = 'none';
    }, 4000);

    setTimeout(function() {
        document.getElementById('errorAlert').style.display = 'none';
    }, 4000);

    setTimeout(function(){
        var nameAlert = document.getElementById('namealert');
        nameAlert.style.opacity = '0';
        nameAlert.style.visibility = 'hidden';
    }, 4000);
</script>
