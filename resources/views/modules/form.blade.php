<div class="form-group">
    <label for="name">名称</label>
    <input id="name" name="name" type="text" class="form-control" placeholder="成员目录">
</div>

<div class="form-group">
    <label for="description">简述</label>
    <input id="description" name="description" type="text" class="form-control" placeholder="简述">
</div>

<div class="form-group">
    <label for="deps">模块依赖</label>

    <div>
        @foreach(\App\Module::all() as $module)
            <span _id="{{ $module->id }}" class="module-btn btn btn-default text-center" style="padding: 20px; margin:10px 5px; width:100px;">
                {{ $module->name }}
            </span>
        @endforeach
    </div>
</div>