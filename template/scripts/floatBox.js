/**
 * Created by Sam on 12/17/15.
 */

/*

    Class FloatBox
    Author: Sam Chou

    Initialization:
        parameters needed: featureList, which is an array contains all the features in floatBox
        It is usually initialized in student.php or teacher.php; therefore,
        developers can simply use floatBox as an already defined variable.
        For example, floatBox.showFeature(...)

    .showFeature(title, id, func)
        title is the title shown on the top of the floatBox
        id is the id of the feature (without "floatBox-" prefix)
        func is the code executed before shown the floatBox (usually used to update loaded data)

    .initialization(func)
        func is the code used to initialize the feature (usually used to clear previously written data)

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
