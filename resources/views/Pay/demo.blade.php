
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>支付Demo</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
   <div class="row">
        <div class="col-md-12">
            <form class="form-inline" method="post" action="{{ $tjurl }}">
                @foreach($jsapi as $k=>$v)
                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                @endforeach
                <button type="submit" class="btn btn-primary btn-lg">支付(金额：{{$jsapi['amount']}}元)</button>
            </form>
        </div>
    </div>

</div>
</body>
</html>