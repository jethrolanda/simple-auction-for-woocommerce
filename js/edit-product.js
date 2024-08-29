jQuery(document).ready(function ($) {
  $(".auction_start_date").datetimepicker({
    format: "Y-m-d H:i",
    onShow: function (ct) {
      this.setOptions({
        maxDate: $(".auction_end_date").val()
          ? $(".auction_end_date").val()
          : false
      });
    }
  });
  $(".auction_end_date").datetimepicker({
    format: "Y-m-d H:i",
    onShow: function (ct) {
      this.setOptions({
        minDate: $(".auction_start_date").val()
          ? $(".auction_start_date").val()
          : false
      });
    }
  });
});
