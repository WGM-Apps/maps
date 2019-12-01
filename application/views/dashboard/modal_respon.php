<form>
    <aside class="modal-body">
        <aside id="accordion">
        <?php foreach($row_group as $res): ?>
            <aside class="card-header" data-toggle="collapse" data-target="#group<?php echo $res->id ?>" aria-expanded="true" aria-controls="group<?php echo $res->id ?>" style="cursor:pointer">
                <?php echo $res->nama ?>
            </aside>
            <aside id="group<?php echo $res->id ?>" class="collapse p-2" aria-labelledby="group<?php echo $res->id ?>" data-parent="#accordion">
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                    </div>
                </div>
                
                <aside class="form-group" id="files<?php echo $res->id ?>"></aside>
                
                <aside class="form-group">
                    <a href="javascript:void(0)" class="btn btn-warning text-white" onclick="addFile<?php echo $res->id ?>();"><i class="fa fa-paperclip"></i> Tambah Keterangan</a> 
                </aside>
            </aside>

            <script>
                //-----Adds an element to the document-------
                function addElement<?php echo $res->id ?>(parentId, elementTag, elementId, html) {
                    var p = document.getElementById(parentId);
                    var newElement = document.createElement(elementTag);
                    newElement.setAttribute('id', elementId);
                    newElement.innerHTML = html;
                    p.appendChild(newElement);
                }

                function removeElement<?php echo $res->id ?>(elementId) {
                    var element = document.getElementById(elementId);
                    element.parentNode.removeChild(element);
                }

                var fileId = 0;
                function addFile<?php echo $res->id ?>() {
                    fileId++;
                    var html =  '<aside class="row">'+
                                '<aside class="col-md-10"><input type="text" name="attachment[]" class="form-control" /></aside>'+
                                '<aside class="col-md-2"><a href="javascript:void(0)" onclick="javascript:removeElement(\'file-' + fileId + '\'); return false;" class="btn btn-outline-danger btn-block">'+
                                '<i class="fa fa-times fa-lg"></i></a></aside>'+
                                '</aside>';
                    addElement<?php echo $res->id ?>('files<?php echo $res->id ?>', 'p', 'file-' + fileId, html);
                }
                //-----Adds an element to the document-------
            </script>
        <?php endforeach ?>
        </aside>
    </aside>
    <aside class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
    </aside>
</form>