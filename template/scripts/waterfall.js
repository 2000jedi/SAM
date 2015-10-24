function Waterfall(id){
    var container = $('#'+id), children = container.children(), height = 0;
    children.each(function(){
        height += $(this).height() + 70;
    });

    var width = container.width(), columnNum = 0;
    if (width < 500){
        columnNum = 0.5;
    }else if ( width < 800){
        columnNum = 1;
    }else{
        columnNum = 2;
    }

    height = height/columnNum;
    container.height(height);

}