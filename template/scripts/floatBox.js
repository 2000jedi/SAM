/**
 * Created by Sam on 12/17/15.
 */

function FloatBox(featureList){
    this.featureList = featureList;

    this.showFeature = function(title, id, func){
        // Disable unused parts
        for (var i = 0; i < this.featureList.length; i++) {
            var feature = this.featureList[i];
            $('#floatBox-' + feature).hide();
        }

        func();
        $('#floatBox-' + id).show();
        $('#floatBox-title').html(title);
        $('#shadow').css("display","table");
    };

    this.initialization = function(func){
        func();
    }
}
