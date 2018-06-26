;(function($){
    var $midimg = $("#midimg"), $winSelector = $("#winSelector");
    var  $imgL = $midimg.offset().left, $imgT = $midimg.offset().top;
    var ImgZoom = function(ele, opt){
        this.ele = ele,
        this.defaults = {
            'H':400,
            'W':400,
            'ratio':2
        },
        this.options = $.extend({}, this.defaults, opt);
    };
    
    ImgZoom.prototype = {
        imgZoom: function(){
            return this.ele;
        },
        bigViewOver: function(e){
            var e=e?e:window.event;
            var oldsrc = $("#bigViewImg").attr("src"), newsrc = $midimg.attr("osrc");
            if( e == null){  return; }
            if(oldsrc != newsrc) {
                $("#bigViewImg").attr("src", newsrc);
            }
            var $bigView = $("#bigViewImg");
            var $x = e.pageX, $y = e.pageY
            ,winSelectorW = this.options.W/this.options.ratio, winSelectorH = this.options.H/this.options.ratio
            , newWinX = e.pageX-winSelectorH/2-$imgL, newWinY = e.pageY-winSelectorH/2-$imgT;
            if( newWinX < 0 ){
                newWinX = 0;
            }else if( newWinX + winSelectorW > this.options.W ){
                newWinX = this.options.W - winSelectorW;
            }
            if( newWinY < 0 ){
                newWinY = 0;
            }else if( newWinY + winSelectorH > this.options.H ){
                newWinY = this.options.H - winSelectorH;
            }
            $winSelector.css({left: newWinX, top: newWinY});
            $bigView.css({left: -newWinX*this.options.ratio, top: -newWinY*this.options.ratio});
            $winSelector.show();
            if($("#bigView").is(":hidden")){
                $("#bigView").show();
            }
        },
        bigViewOut: function(){
            $("#bigView").hide();
            $("#winSelector").hide();
        },
        midImg: function( obj ){
            if(!obj) return false;
            $midimg.attr("src", obj.find("img").attr("src"));
            $midimg.attr("osrc", obj.find("img").attr("osrc"));
            obj.siblings("li").removeClass("smallImgSelected");
            obj.addClass("smallImgSelected");
        }
    };
    
    $.fn.imgZoom = function(options){
        var imgZoom = new ImgZoom(this, options);
        $winSelector.css({
            'width': imgZoom.options.W/imgZoom.options.ratio,
            'height': imgZoom.options.H/imgZoom.options.ratio
        });
        $(".bigImg,#bigView").css({
            'width': imgZoom.options.W,
            'height': imgZoom.options.H
        });
        $("#bigView").css({
            'left': imgZoom.options.W+5
        });
        $("#bigViewImg").css({
            'width': imgZoom.options.W*imgZoom.options.ratio,
            'height': imgZoom.options.H*imgZoom.options.ratio
        });
        $("#imageMenu").css({
            'width': imgZoom.options.W
        });
        $(".smallImg").on('mouseover', function(){
            imgZoom.midImg($(this));
        });
        $("#midimg, #winSelector").on('mousemove', function(e){
            imgZoom.bigViewOver(e);
        });
        $("#winSelector").on('mouseleave', function(e){
            imgZoom.bigViewOut();
        });
        return imgZoom.imgZoom();
    };
})(jQuery);