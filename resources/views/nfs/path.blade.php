<ul class="items">
    @foreach (\App\NFS::path($project, $path, 'directory') as $directory)
    <li class="item">
        <a href="{{ route('nfs.path', ['project_id'=> $project->id, 'path'=> $path. '/'. $directory]) }}">
            <span class="square">
                <img src="assets/svg/folder.svg" alt="folder">
            </span>
            <span class="label">
                {{ $directory }}
            </span>
        </a>
    </li>
    @endforeach

    @foreach (\App\NFS::path($project, $path, 'file') as $file)
       <li class="item">
           <div>
               <a href="{{ route('nfs.download', ['project_id'=> $project->id, 'file'=> $path. '/'. $file]) }}">
               <span class="square">
                    <img src="assets/svg/file.svg" alt="folder">
               </span>
               <span class="label">
                   {{ $file }}
               </span>
               </a>
           </div>


           <div class="action">
               <span>

                   <form method="post" action="{{ route('nfs.delete', ['project'=> $project, 'file'=> $path. '/'. $file]) }}">
                       <button type="submit" class="btn btn-danger btn-sm delete">
                           <i class="fa fa-fw fa-times"></i>
                       </button>
                   </form>

               </span>
               <span>

                   <button data-path="{{ $path }}" data-file="{{ $file }}" data-project-id="{{ $project->id }}" class="btn edit-btn btn-primary btn-sm" href="#">
                       <i class="fa fa-fw fa-edit"></i>
                   </button>

               </span>

           </div>


       </li>
    @endforeach
</ul>

<form method="post" style="width: 40%;float: right; margin-right: 20px;" enctype="multipart/form-data" action="{{ route('nfs.upload', ['project'=> $project]) }}">

    <p class="pull-right">
        <input name="path" type="hidden" value="{{ $path }}">
        <input class="file " name="file" type="file" style="display: inline;" data-show-preview="false">
    </p>
</form>

<div class="modal fade" id="file-edit" tabindex="-1" role="dialog" aria-labelledby="file-edit-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="edit-server-modal-label">文件重命名</h4>
            </div>
            <div class="modal-body">
                <form id="edit-client-form" class="form-horizontal" method="post" action="{{ route('nfs.edit') }}">
                    <input type="hidden" name="project_id">
                    <input type="hidden" name="path">
                    <input type='hidden' name="file">

                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" disabled="disabled" name="display_file" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" name="rename" class="form-control" placeholder="新名称">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="submit" class="btn btn-primary" form="edit-client-form">修改</button>
            </div>
        </div>
    </div>
</div>