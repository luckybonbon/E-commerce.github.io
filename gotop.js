(function($){
    $("body").append("<img id='goTopButton' style='display:none; z-index:5; cursor: pointer; top:100px; right:100px; position:fixed;' title='回到頂端'/>");
    var img = "bntop01.png",
      location = 0.8,
      right = 10,
      opacity = 0.6,
      speed = 500,
      $button = $("#goTopButton"),
      $body = $(document),
      $win = $(window);
    $button.attr("src", img);
    window.goTopMove = function () {
      var scrollH = $body.scrollTop(),
        winH = $win.height(),
        css = { "top": winH * location + "px", "position" : "fixed", "right": right, "opacity" : opacity };
      if (scrollH > 20){
        $button.css(css);
        $button.fadeIn("slow");
      } else{
        $button.fadeOut("slow");
        css={"transform": "none", "transition":"none"};
        $button.css(css);
      }
    };
    $win.on({
      scroll: function () {goTopMove();},
      resize: function () {goTopMove();}
    });
    $button.on({
      mouseover: function(){$button.css("opacity",1);},
      mouseout: function(){$button.css("opacity", opacity);},
      click: function(){
        css={"transform": "rotate(720deg)", "transition": "transform 1s ease 0s"};
        $button.css(css);
        $("html, body").animate({scrollTop: 0}, speed);}
    });
  })(jQuery);