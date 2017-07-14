<style>
    *{
        margin: 0;
        padding: 0;
    }
    td{
        padding: 5px;
    }
    hr{
        margin-bottom: 10px;
    }
</style>
<body style="margin: 0; padding: 0;">
<table class="">
    <tr>
        <td>{{$name}}您好：</td>
    </tr>
    <tr>
        <td>
            <h4>到今日一共 {{count($comments)}} 人接龙</h4>
        </td>
    </tr>
    <tr>
        <td>
            <h4 style="">团主题:</h4>
            <p>
                {{$group->description}}
            </p>
            <hr />
            <h4>接龙信息:</h4>
        </td>
    </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td bgcolor="#FFCC00">索引</td>
        <td bgcolor="#FFCC00">微信花名</td>
        <td bgcolor="#FFCC00">姓名</td>
        <td bgcolor="#FFCC00">电话</td>
        <td bgcolor="#FFCC00" style="max-width: 100px;">备注</td>
        <td bgcolor="#FFCC00">订单信息</td>
        <td bgcolor="#FFCC00">总价</td>
    </tr>
    <repeater>
        @foreach ($comments as $comment)
        <layout label="White row">
            <tr @if ($loop->index%2 !=0) bgcolor="#CCCCCC" @endif>
                <td>
                    <multiline label="Heading 1 text">{{ $loop->index+1 }}</multiline>
                </td>
                <td>
                    <multiline label="Heading 1 text">{{ $comment->alias }}</multiline>
                </td>
                <td>
                    <multiline label="Heading 1 text">{{ $comment->name }}</multiline>
                </td>
                <td>
                    <multiline label="Heading 1 text">{{ $comment->phone }}</multiline>
                </td>
                <td style="max-width: 100px;">
                    <multiline label="Heading 2 text">{{ $comment->comment }}</multiline>
                </td>
                <td style="max-width: 100px;">
                    <multiline label="Heading 3 text">{{ $comment->product_comment }}</multiline>
                </td>
                <td>
                    <multiline label="Heading 3 text">{{ $comment->total_price }}</multiline>
                </td>
            </tr>
        </layout>
        @endforeach
    </repeater>
</table>
</body>