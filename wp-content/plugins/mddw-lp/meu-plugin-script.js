jQuery(document).ready(function($){
    var frame;

    $(document).on('click', '.upload-image-button', function(e){
        e.preventDefault();

        var button = $(this);
        var index = button.data('index');

        // Se o frame já existe, abre ele
        if (frame) {
            frame.open();
            return;
        }

        // Cria a media frame.
        frame = wp.media({
            title: 'Selecionar ou Enviar Mídia',
            button: {
                text: 'Usar esta mídia'
            },
            multiple: false
        });

        // Quando uma imagem é selecionada no media frame...
        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            $('#meu_plugin_imagem_' + index).val(attachment.id);
            $('#image-preview-' + index).html('<img src="' + attachment.url + '" style="max-width:100%;"/>');
        });

        // Abre o media frame.
        frame.open();
    });

    // Adiciona um novo campo de metabox
    $('#add-meta-box').on('click', function(e){
        e.preventDefault();

        var container = $('#meu-plugin-metabox-container');
        var index = container.find('.meu-plugin-meta-box').length;

        var html = '<div class="meu-plugin-meta-box">';
        html += '<label for="meu_plugin_texto_' + index + '">Texto:</label></br>';
        html += '<input type="text" id="meu_plugin_texto_' + index + '" name="meu_plugin_texto[]" value="" size="25" /></br>';
        html += '<label for="meu_plugin_url_' + index + '">URL:</label></br>';
        html += '<input type="url" id="meu_plugin_url_' + index + '" name="meu_plugin_url[]" value="" size="25" /></br>';
        html += '<label for="meu_plugin_imagem_' + index + '">Imagem:</label></br>';
        html += '<input type="hidden" id="meu_plugin_imagem_' + index + '" name="meu_plugin_imagem[]" value="" />';
        html += '<button type="button" class="upload-image-button button" data-index="' + index + '">Selecionar Imagem</button>';
        html += '<div class="image-preview" id="image-preview-' + index + '" style="width: 250px;"></div>';
        html += '<button type="button" class="remove-meta-box">Remover</button>';
        html += '</div>';

        container.append(html);
    });

    // Remove um campo de metabox
    $(document).on('click', '.remove-meta-box', function(e){
        e.preventDefault();
        $(this).closest('.meu-plugin-meta-box').remove();
    });
});
