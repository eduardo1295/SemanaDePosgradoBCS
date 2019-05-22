<div style="text-align:center;width:100px" class="mx-auto">

    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $id }}" data-original-title="Editar"
        style="height:40px" class="edit btn btn-xs btn-primary editar">
        <span><i class="fas fa-edit"></i>
        </span></a>


    <a href="javascript:void(0);" id="eliminar" data-toggle="tooltip" data-original-title="Eliminar"
        data-id="{{ $id }}" class="delete btn btn-xs btn-danger eliminar" style="height:40px">
        <span><i class="fas fa-trash-alt"></i>
        </span></a>
</div>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({
            trigger : 'hover'
        }) 
    });
</script>