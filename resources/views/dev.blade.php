@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">SQL 查询导出</div>

                    <div class="card-body">
                        <form id="form" method="POST" action="{{ route('dev') }}">
                            @csrf
                            <div class="form-group">
                                <label for="sql">输入 SQL 查询语句：</label>
                                <input type="text" class="form-control" id="sql" name="sql" placeholder="请输入查询语句" required onblur="validateInput()">
                                <small class="form-text text-muted">只支持输入 SELECT 语句。</small>
                            </div>

                            <div class="text-center">
                                <button type="button" id="excute" onclick="excuteData()" class="btn btn-primary mr-2">Excute</button>
                                <div class="form-group">
                                    <label for="exportFormat">选择导出格式：</label>
                                    <select class="form-control" id="exportFormat" name="exportFormat">
                                        <option value="excel">Export Excel</option>
                                        <option value="json">Export JSON</option>
                                    </select>
                                </div>
                                <button type="button" id="export" class="btn btn-primary">执行并导出</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    function excuteData () {
        $('#exportFormat').val(null)
        $('#form').submit();
    }

    function validateInput() {
        var sql = $('#sql').val().trim();
        if (!sql.toLowerCase().startsWith('select')) {
            alert('Only Support to Input Select Sql, Please try again')
        }
    }
</script>


