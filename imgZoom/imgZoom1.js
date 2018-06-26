;(function($){
    var $midimg = $("#midimg");
    var $imgL = $midimg.offset().left, $imgT = $midimg.offset().top
    , $imgH = $midimg.height(), $imgW = $midimg.width();
    var myDelay = null, auth = false;
    var ImgZoom = function(ele, opt){
        this.ele = ele,
        this.defaults = {
            
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
            var $bigView = $("#bigViewImg"), $winSelector = $("#winSelector");
            var $x = e.pageX, $y = e.pageY
            , $bigViewW = $bigView.width(), $bigViewH = $bigView.height()
            , $winSelectorH = $winSelector.height(), $winSelectorW = $winSelector.width()
            , newWinX = e.pageX-$winSelectorW/2-$imgL, newWinY = e.pageY-$winSelectorH/2-$imgT;
            if( newWinX < 0 ){
                newWinX = 0;
            }else if( newWinX + $winSelectorW > $imgW ){
                newWinX = $imgW - $winSelectorW;
            }
            if( newWinY < 0 ){
                newWinY = 0;
            }else if( newWinY + $winSelectorH > $imgH ){
                newWinY = $imgH - $winSelectorH;
            }
            $winSelector.css({left: newWinX, top: newWinY});
            $bigView.css({left: -newWinX*$bigViewW/$imgW, top: -newWinY*$bigViewH/$imgH});
            $winSelector.show();
            if($("#bigView").is(":hidden")){
                $("#bigView").show();
            }
            auth = true;
        },
        bigViewOut: function(){
            $("#bigView").hide();
            $("#winSelector").hide();
            auth = false;
            $(window).unbind('mousemove');
        },
        elocation: function(e){
            var e=e?e:window.event;
            var $x = e.pageX, $y = e.pageY;
            if( $x > $imgL && ($imgL+ $imgW) > $x && $y > $imgT && ($imgT+ $imgH) > $y ){
                return true;
            }else{
                return false;
            }
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
        $(".smallImg").on('mouseover', function(){
            imgZoom.midImg($(this));
        });
        $midimg.on('mouseenter', function(){
            $(window).bind('mousemove', function(e){
                if(imgZoom.elocation(e)){
                    imgZoom.bigViewOver(e);
                }else if(auth){
                    imgZoom.bigViewOut();
                }
            });
        });
        return imgZoom.imgZoom();
    };
})(jQuery);