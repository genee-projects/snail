@extends('layout')

@section('content')

    <script src="asserts/3rd/ace/build/src/ace.js" type="text/javascript"></script>
    <script src="asserts/3rd/ace/build/src/theme-github.js" type="text/javascript"></script>
    <script src="asserts/3rd/ace/build/src/mode-text.js" type="text/javascript"></script>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">模板生成器</h1>
        </div>

        <div class="col-lg-3">
            <h3>
                变量列表:
            </h3>
            <table class="table table-striped table-hover table-bordered">
                <tbody>
                    <tr>
                        <td>功能</td>
                        <td>变量</td>
                    </tr>
                    <tr>
                        <td>fqdn</td>
                        <td><code>{ $fqdn }</code></td>
                    </tr>

                    <tr>
                        <td>当前版本</td>
                        <td><code>{ $version }</code></td>
                    </tr>

                    <tr>
                        <td>名称</td>
                        <td><code>{ $name }</code></td>
                    </tr>


                    <tr>
                        <td>名称</td>
                        <td><code>{ $name }</code></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-lg-9">
            <h3>
                请填写模板:
            </h3>

            <div id="editor">some text</div>

            <p class="pull-right" style="margin-top: 20px;">
                <button class="btn btn-primary btn-info"><i class="fa fa-code"></i> 生成模板</button></p>
            </p>
        </div>
    </div>


    <script>
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/github");

        var TextMode = ace.require("ace/mode/text").Mode;
        editor.session.setMode(new TextMode());

        editor.setOption("showPrintMargin", false)
    </script>

    <style type="text/css">
        #editor {
            width: 100%;
            height: 300px;
        }
    </style>

@endsection

