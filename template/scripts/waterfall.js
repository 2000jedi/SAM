var masonryOpt = function(prefix){
    return {
        itemSelector: '.' + prefix,
        columnWidth: 300,
        isFitWidth: true,
        "gutter": 20
    }
};
var updateMasonry = function(prefix){
    $("#"+prefix).masonry(masonryOpt(prefix));
};