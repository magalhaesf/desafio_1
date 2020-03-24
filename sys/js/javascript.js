const round = (num, places) => {
	if (!("" + num).includes("e")) {
		return +(Math.round(num + "e+" + places)  + "e-" + places);
	} else {
		let arr = ("" + num).split("e");
		let sig = ""
		if (+arr[1] + places > 0) {
			sig = "+";
		}

		return +(Math.round(+arr[0] + "e" + sig + (+arr[1] + places)) + "e-" + places);
    }
}
$(document).ready(function(){
    $(document).on('click', '.btn-menu:not(#btn-sair)',function(){
        $('.btn-menu').removeClass('active');
        $(this).addClass('active');
        $('#rowConteudo').load($(this).data('caminho'));
    });
    $.ajax({
        url : "acoes/menu.php",
        type : 'POST',
        beforeSend : function(){
            $("#rowMenu").html("<div class='loader'></div>");
        }
    })
    .done(function(html){
        if (html == 'sair') {
            window.location.replace('../');
        } else {
            $("#rowMenu").html(html);
        }
    })
    .fail(function(jqXHR, textStatus, msg){
        alert(msg);
    });
    $(document).on('click', '.btn-salvar',function(){        
        var validaInput = true;
        $('#frmInserirAlterar input').each(function(index){  
            var input = $(this).val();
            if (input.trim() == '') {
                validaInput = false;
            }                
        });

        if (validaInput == false) {
            $('#modal_btn_salvar').hide();
            $("#modal_sys_body").html('Por favor, preencha todos os campos!');
        } else {
            $.ajax({
                url : "acoes/salvar.php",
                type : 'POST',
                data: $('#frmInserirAlterar').serialize()
            })
            .done(function(html){
                $('#modal_btn_salvar').hide();
                if (html == 1) {
                    $("#modal_sys_body").html('Registro inserido com sucesso!');
                    $('#tabela').DataTable().ajax.reload();
                } else {
                    $("#modal_sys_body").html('Falha ao inserir o registro.');
                }
            })
        }
    }); 
    $(document).on('click', '#tabela tbody tr', function () {
        var data = $('#tabela').DataTable().row(this).data();
        $.ajax({
            url : "acoes/consultar.php",
            type : 'POST',
            data : {cod_registro: data[0],
                    codigo: $('#codigo').val()}
        })
        .done(function(html){
            var resultado = html.split('#');
            switch ($('#codigo').val()) {
                case '1':
                    var formulario = '<form id="frmInserirAlterar" method="POST"><div class="form-group"><label for="descricao">Descrição</label><input type="text" class="form-control" id="descricao" name="descricao" placeholder="Quilograma" value="'+resultado[1]+'"></div><div class="form-group"><label for="abreviacao">Abreviação</label><input type="text" class="form-control" id="abreviacao" name="abreviacao" placeholder="Kg" value="'+resultado[2]+'"></div><input type="hidden" value="'+$('#codigo').val()+'" name="codigo"><input type="hidden" value="alterar" name="acao"><input type="hidden" value="'+resultado[0]+'" name="cod_unidade"></form>';
                    $('#modal_sys_title').html('Unidades');
                    $('#modal_sys_body').html(formulario);
                break;
                case '2':
                    var formulario = '<form id="frmInserirAlterar" method="POST"><div class="form-group"><label for="descricao">Descrição</label><input type="text" class="form-control" id="descricao" name="descricao" placeholder="Cereais" value="'+resultado[1]+'"></div><div class="form-group"><label for="imposto">Imposto</label><input type="text" class="form-control" id="imposto" name="imposto" placeholder="5,5" value="'+resultado[2]+'"></div><input type="hidden" value="'+$('#codigo').val()+'" name="codigo"><input type="hidden" value="alterar" name="acao"><input type="hidden" value="'+resultado[0]+'" name="cod_tipo_produtos"></form>';
                    $('#modal_sys_title').html('Tipo de produtos');
                    $('#modal_sys_body').html(formulario);
                break;
                case '3':
                    var formulario = '<form id="frmInserirAlterar" method="POST"><div class="form-group"><label for="descricao">Descrição</label><input type="text" class="form-control" id="descricao" name="descricao" placeholder="Feijão" value="'+resultado[1]+'"></div><div class="form-group"><label for="valor">Valor</label><input type="text" class="form-control" id="valor" name="valor" placeholder="8,40" value="'+resultado[2]+'"></div><div class="form-group"><label for="id_tipo_produtos">Tipo de produto</label><select class="form-control" id="id_tipo_produtos" name="id_tipo_produtos"></select></div><div class="form-group"><label for="id_unidades">Unidade</label><select class="form-control" id="id_unidades" name="id_unidades"></select></div><input type="hidden" value="3" name="codigo"><input type="hidden" value="alterar" name="acao"><input type="hidden" value="'+resultado[0]+'" name="cod_produto"></form>';
                    $('#modal_sys_title').html('Produtos');
                    $('#modal_sys_body').html(formulario);
                    $.getJSON('acoes/tipoProdutos.php', function (data) {
                        $.each(data, function (key, entry) {
                            $.each(entry, function (k, e) {
                                if (resultado[3] == e[0]) {
                                    $('#id_tipo_produtos').append($('<option selected></option>').attr('value', e[0]).text(e[1]));
                                } else {
                                    $('#id_tipo_produtos').append($('<option></option>').attr('value', e[0]).text(e[1]));
                                }
                            })
                        })
                    });
                    $.getJSON('acoes/unidades.php', function (data) {
                        $.each(data, function (key, entry) {
                            $.each(entry, function (k, e) {
                                if (resultado[4] == e[0]) {
                                    $('#id_unidades').append($('<option selected></option>').attr('value', e[0]).text(e[1]));
                                } else {
                                    $('#id_unidades').append($('<option></option>').attr('value', e[0]).text(e[1]));
                                }
                            })
                        })
                    });
                break;
                case '4':
                break;
            }
            $('#modal_btn_salvar').show();
            $('#modal_sys').modal('show');
        })
    });
    $(document).on('click', '#btn-sair', function(){
        $.ajax({
            url : "acoes/sair.php",
            type : 'POST'
        })
        .done(function(retorno){
            if (retorno == 'sair') {
                window.location.replace('../');
            }
        })
    });
});