jQuery(document).ready(function ($) {
  // Initialize tabs
  $("#wp-resume-builder-tabs").tabs();

  // Initialize color pickers
  $(".wp-resume-builder-color-picker").wpColorPicker();

  // Handle repeater fields
  $(".wp-resume-builder-repeater").each(function () {
    var $repeater = $(this);
    var field = $repeater.data("field");
    var $itemsContainer = $repeater.find(".wp-resume-builder-repeater-items");
    var $template = $("#tmpl-wp-resume-builder-" + field + "-item");
    var index = $itemsContainer.children().length;

    function addNewItem() {
      var newItem = $template.html().replace(/\{\{data\.index\}\}/g, index);
      $itemsContainer.append(newItem);
      index++;
    }

    $repeater.on("click", ".wp-resume-builder-add-item", function () {
      addNewItem();
    });

    $repeater.on("click", ".wp-resume-builder-remove-item", function () {
      $(this).closest(".wp-resume-builder-repeater-item").remove();
    });
  });
});
