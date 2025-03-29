<html>
<body>
<form action="{{route('checkPaymentReq')}}" method="POST">
    @csrf
    <input type="text" name="token" />
    <button>check</button>
</form>
</body>
</html>
