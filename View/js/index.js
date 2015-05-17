/**
 * Created by lenovo on 2015/4/4.
 */

//slider事件
var slider = document.getElementById('slider');
var sliderLi = slider.getElementsByTagName('li');
var timer = pl= null;
var index = 1;
function autoPlay(){
    pl= setInterval(function(){
        index >= sliderLi.length && (index = 0);
        show(index);
        index++;
    },4000);
}
autoPlay();

function show(index){
    var alpha = 0;
    for(var i=0;i<sliderLi.length;i++){
        sliderLi[i].style.opacity = 0;
        sliderLi[i].filter ="alpha(opacity=0)";
    }

    timer = setInterval(function(){
        alpha += 2;
        alpha > 100 && (alpha = 0);
        sliderLi[index].style.opacity = alpha/100;
        sliderLi[index].style.filter = "alpha(opacity="+ alpha+")";
        alpha == 100 && (clearInterval(timer));
    },20);
}
var cList = document.getElementById('c-part1-list').getElementsByTagName('li');
for(var i=0;i<cList.length;i++){
    cList[i].onclick = function(){
        var x = this.innerHTML;
        window.location = '/book_search' + x;
    }
}