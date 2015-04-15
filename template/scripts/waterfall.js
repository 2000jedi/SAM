function WaterFall(list, prefix, panelOpen){
    if ($(window).width() < 955){
        panelOpen = false;
    }
    var ifCompensate = panelOpen ? 1:0, widthOfWindow = $('#body-part').width() - rightBarTheoreticalWidth * ifCompensate, widthEachCard = 370;
    var numberOfColumns = Math.floor(widthOfWindow / (widthEachCard + 10 ) );

    var idList = list;
    var idListArr = idList.split(";");

    if (numberOfColumns != 1 && numberOfColumns != 0 || ($(window).width() > 740 && widthOfWindow > widthEachCard)) {
        var heightStorage = new Array();
        for (var i = 0; i < numberOfColumns; i++){
            heightStorage[i] = 0.5;
        }

        function minIndexOfArray(arr){
            var index = 0;
            var minVal = 100000;
            for (var i = 0; i < arr.length; i++){
                if ( arr[i] < minVal ){
                    index = i;
                    minVal = arr[i];
                }
            }
            return index;
        }

        var startLeftPoint = ( widthOfWindow / 16 - numberOfColumns * 23 - (numberOfColumns - 0.5) )/2;

        for (var i = 1; i < idListArr.length; i++){
            var id = idListArr[i];
            var node = document.getElementById(prefix+id);
            node.style.position = "absolute";

            node.style.width = "23em";
            node.style.margin = "0px";

            var height = node.clientHeight / 16;

            var columnID = minIndexOfArray(heightStorage);
            var leftVal = startLeftPoint + columnID + 23 * columnID;
            // Initial margin to the left + margin to the right + content width;
            var topVal = heightStorage[columnID];
            heightStorage[columnID] = topVal + height + 1;

            node.style.left = leftVal + "em";
            node.style.top = topVal + "em";
        }
    }else{
        for (var i = 1; i < idListArr.length; i++) {
            var id = idListArr[i];
            var node = document.getElementById(prefix+id);
            node.style.position = "";
            node.style.left = "";
            node.style.top = "";
            node.style.width = "";
            node.style.margin = "";
        }
    }
}