(function($){
  function fetchPosts(postType, search, cb){
    $.get(ajaxurl, {
      action: 'gncps_get_posts',
      post_type: postType,
      search: search || ''
    }, function(resp){
      if(resp && resp.success && typeof cb === 'function'){
        cb(resp.data);
      }
    });
  }

  function updatePosts($modal){
    var postType   = $modal.find('select[name$="post_type"]').val() || 'post';
    var search     = $modal.find('.gncps-search-input').val() || '';
    var postsField = $modal.find('[data-field-key="posts"]');
    var container  = postsField.find('.et-pb-option-container');
    if(!container.length) return;

    var inputName = postsField.data('input-name');
    if(!inputName){
      inputName = container.find('input[type="checkbox"]').first().attr('name') || '';
      postsField.data('input-name', inputName);
    }

    var prevType = postsField.data('prev-post-type');
    var selected = {};
    if(prevType === postType){
      container.find('input:checked').each(function(){ selected[$(this).val()] = true; });
    } else {
      postsField.data('prev-post-type', postType);
    }

    fetchPosts(postType, search, function(posts){
      container.empty();
      $.each(posts, function(i, p){
        var checked = selected[p.id] ? ' checked="checked"' : '';
        container.append('<label class="et_pb_checkbox_label"><input type="checkbox" name="'+inputName+'" value="'+p.id+'"'+checked+'> '+p.title+'</label>');
      });
      container.find('input').trigger('change');
    });
  }

  $(document).on('et_builder_open_settings', function(e, modal){
    var $modal = $(modal);
    var postsField = $modal.find('[data-field-key="posts"]');
    if(!postsField.length) return;
    if(!postsField.data('gncps-initialized')){
      postsField.data('gncps-initialized', true);
      postsField.find('.et-pb-option-container').before('<input type="text" class="gncps-search-input" placeholder="Search posts..." style="margin-bottom:10px;width:100%;" />');
      postsField.on('keyup', '.gncps-search-input', function(){ updatePosts($modal); });
      $modal.find('select[name$="post_type"]').on('change', function(){ updatePosts($modal); });
    }
    updatePosts($modal);
  });
})(jQuery);

