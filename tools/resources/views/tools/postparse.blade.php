<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        input, select {
            height: 30px;
        }
        a{
            color:lightsteelblue;
        }
        textarea {
            width: 800px;
            height: 60px;
        }
        .confluenceTable, .table-wrap {
            margin: 10px 0 0 0;
            overflow-x: auto;
        }
        .confluenceTh, .confluenceTd {
            border: 1px solid #ddd;
            padding: 7px 10px;
            vertical-align: top;
            text-align: left;
        }
        .panel, .alertPanel, .infoPanel {
            color: #333;
            padding: 0;
            margin: 10px 0;
            border: 1px solid #ddd;
            overflow: hidden;
            border-radius: 3px;
        }

        .wiki-content table.wysiwyg-macro {
            border: 5px solid #f0f0f0;
            background-color: #fff;
            background-repeat: no-repeat;
            padding: 0;
        }
        .wiki-content table.wysiwyg-macro {
            border-collapse: separate;
        }
        .wysiwyg-macro {
            width: 99.46%;
        }

        .wiki-content .wysiwyg-macro {
            width: 100%;
            padding: 24px 2px 2px 2px;
        }
        p+table.wysiwyg-macro, table.wysiwyg-macro+p {
            margin-top: 10px;
        }
        .wysiwyg-macro {
            background-color: #f0f0f0;
            background-repeat: no-repeat;
            background-position: 0 0;
            border: 1px solid #ddd;
        }
        user agent stylesheet
        table {
            display: table;
            border-collapse: separate;
            border-spacing: 2px;
            border-color: grey;
        }

    </style>
    <script src="{{asset('js/jquery-1.9.1.min.js')}}"></script>
    <script src="{{asset('js/clipboard.js')}}"></script>
</head>
<body>
<form action="{{$api}}" method="post">
    <table>
        @if(!empty($code))
        @foreach($code as $key=>$item)
        <tr>
        <td>{{$item[0]}}</td><td><input name="{{$item[0]}}" value="{{$item[1]}}" /></td>
        </tr>
        @endforeach
        @endif
        <tr><td><input type="submit" /></td></tr>
    </table>
</form>
</body>
</html>