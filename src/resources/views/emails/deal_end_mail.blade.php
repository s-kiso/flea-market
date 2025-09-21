<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/emails/deal_end_mail.css') }}">
</head>
<body>
    <p>{{ $user_name }}　様</p>
    <p>coachtechフリマをご利用いただきありがとうございます。</p>
    <p>下記商品の取引が完了いたしました。URLより取引相手の評価をお願いいたします。</p>
    <ul>
        <li>商品名：{{ $item }}</li>
        <li>URL：<a href="http://localhost/deal/:{{ $url }}">http://localhost/deal/:{{ $url }}</a></li>
    </ul>
    <p>いつもご利用いただきありがとうございます。</p>
    <p>coachtechフリマ担当者</p>
    <a href="http://localhost/">coachtechフリマトップページ</a>
</body>
</html>