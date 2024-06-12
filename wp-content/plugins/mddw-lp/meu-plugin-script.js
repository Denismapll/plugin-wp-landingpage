jQuery(document).ready(function($) {
  $('#add-meta-box').click(function() {
      var index = $('.meu-plugin-meta-box').length;
      $('#meu-plugin-metabox-container').append(
          '<div class="meu-plugin-meta-box">' +
          '<label for="meu_plugin_texto_' + index + '">Texto:</label>' +
          '<input type="text" id="meu_plugin_texto_' + index + '" name="meu_plugin_texto[]" size="25" />' +
          '<label for="meu_plugin_url_' + index + '">URL:</label>' +
          '<input type="url" id="meu_plugin_url_' + index + '" name="meu_plugin_url[]" size="25" />' +
          '<button type="button" class="remove-meta-box">Remover</button>' +
          '</div>'
      );
  });

  $(document).on('click', '.remove-meta-box', function() {
      $(this).closest('.meu-plugin-meta-box').remove();
  });
});
