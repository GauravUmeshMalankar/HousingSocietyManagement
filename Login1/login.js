$(document).ready(function () {
  // Focus effect for input fields
  $(".input input, .input select").focus(function () {
    $(this).parent(".input").find("label").css({
      "color": "#E91E63",
      "font-weight": "bold"
    });
  }).blur(function () {
    $(this).parent(".input").find("label").css({
      "color": "#555",
      "font-weight": "normal"
    });
  });

  // Login button click effect
  
  $(document).ready(function () {
    $(".button.login button").click(function () {
      $(this).addClass("active");
      setTimeout(() => {
        $(this).removeClass("active");
      }, 300);
    });
  });

  // User type selection with glow effect
  $(".user-type select").focus(function () {
    $(this).parent(".input").find("label").css({
      "color": "#E91E63",
      "font-weight": "bold"
    });
  }).blur(function () {
    $(this).parent(".input").find("label").css({
      "color": "#555",
      "font-weight": "normal"
    });
  });

  $(".user-type select").change(function () {
    let userType = $(this).val();
    $(".selected-user-type").text("Selected User Type: " + userType).css({
      "color": "#E91E63",
      "font-weight": "bold"
    });
  });
});