/*

    Part I: AJAX Handling Loading
    This part is used to display the loading sign to assuage user's anxiety

 */
$(document).ajaxSend(function(event,xhr,option){
    if (option.type === "GET"){
        $('#loading').show();
    }
    if (option.type === "POST"){
        $('#loading').show();
    }
});
$(document).ajaxComplete(function(){
    $('#loading').hide();
});
// Part I ends


/*

    Part II: Operation Libraries
    This part is used to process basic operations

    DateDiff.inDays(d1, d2) calculates the date difference between two days
    Util.string
        .url.RegexFormat(str) gives the link in text a <a></a>
        .line.RegexFormat(str) gives ENTER in text a <br/>
        .formattedPostContent(str) combines url and line regex format

 */
var DateDiff = {
    inDays: function(d1, d2) {
        var t2 = new Date(d2.setHours(0,0,0,0)).getTime();
        var t1 = new Date(d1.setHours(0,0,0,0)).getTime();
        return parseInt((t2-t1)/(24*3600*1000));
    }
};
var Utils = {
    string:{
        url:{
            Regex:function(){
                // Regular Expression for URL validation https://gist.github.com/dperini/729294
                // Author: Diego Perini
                // Updated: 2010/12/05
                return /(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?/gi;
            },
            RegexFormat:function(str){
                return str.replace(this.Regex(),function(word){
                    return "<a href=\"" + word + "\" target=_blank>" + word + "</a>";
                });
            }
        },
        line:{
            Regex:function(){
                return /\n|\r\n|\r/g;
            },
            RegexFormat:function(str){
                return str.replace(this.Regex(),"<br>");
            }
        },
        formattedPostContent:function(str){
            str = this.url.RegexFormat(str);
            str = this.line.RegexFormat(str);
            return str;
        }
    }
};
// Part II ends


/*

    Part III: Fix Safari
    It is a third party library

    - From the original author:
        This library re-implements setTimeout, setInterval, clearTimeout, clearInterval for iOS6.
        iOS6 suffers from a bug that kills timers that are created while a page is scrolling.
        This library fixes that problem by recreating timers after scrolling finishes (with interval correction).
        This code is free to use by anyone (MIT, blabla).
        Original Author: rkorving@wizcorp.jp

  */
(function (window) {
    var timeouts = {};
    var intervals = {};
    var orgSetTimeout = window.setTimeout;
    var orgSetInterval = window.setInterval;
    var orgClearTimeout = window.clearTimeout;
    var orgClearInterval = window.clearInterval;
    // To prevent errors if loaded on older IE.
    if (!window.addEventListener) return false;
    // This fix needs only for iOS 6.0 or 6.0.1, continue process if the version matched.
    if (!navigator.userAgent.match(/OS\s6_0/)) return false;
    function createTimer(set, map, args) {
        var id, cb = args[0],
            repeat = (set === orgSetInterval);

        function callback() {
            if (cb) {
                cb.apply(window, arguments);
                if (!repeat) {
                    delete map[id];
                    cb = null;
                }
            }
        }
        args[0] = callback;
        id = set.apply(window, args);
        map[id] = {
            args: args,
            created: Date.now(),
            cb: cb,
            id: id
        };
        return id;
    }

    function resetTimer(set, clear, map, virtualId, correctInterval) {
        var timer = map[virtualId];
        if (!timer) {
            return;
        }
        var repeat = (set === orgSetInterval);
        // cleanup
        clear(timer.id);
        // reduce the interval (arg 1 in the args array)
        if (!repeat) {
            var interval = timer.args[1];
            var reduction = Date.now() - timer.created;
            if (reduction < 0) {
                reduction = 0;
            }
            interval -= reduction;
            if (interval < 0) {
                interval = 0;
            }
            timer.args[1] = interval;
        }
        // recreate
        function callback() {
            if (timer.cb) {
                timer.cb.apply(window, arguments);
                if (!repeat) {
                    delete map[virtualId];
                    timer.cb = null;
                }
            }
        }
        timer.args[0] = callback;
        timer.created = Date.now();
        timer.id = set.apply(window, timer.args);
    }
    window.setTimeout = function () {
        return createTimer(orgSetTimeout, timeouts, arguments);
    };
    window.setInterval = function () {
        return createTimer(orgSetInterval, intervals, arguments);
    };
    window.clearTimeout = function (id) {
        var timer = timeouts[id];
        if (timer) {
            delete timeouts[id];
            orgClearTimeout(timer.id);
        }
    };
    window.clearInterval = function (id) {
        var timer = intervals[id];
        if (timer) {
            delete intervals[id];
            orgClearInterval(timer.id);
        }
    };
    //check and add listener on the top window if loaded on frameset/iframe
    var win = window;
    while (win.location != win.parent.location) {
        win = win.parent;
    }
    win.addEventListener('scroll', function () {
        // recreate the timers using adjusted intervals
        // we cannot know how long the scroll-freeze lasted, so we cannot take that into account
        var virtualId;
        for (virtualId in timeouts) {
            resetTimer(orgSetTimeout, orgClearTimeout, timeouts, virtualId);
        }
        for (virtualId in intervals) {
            resetTimer(orgSetInterval, orgClearInterval, intervals, virtualId);
        }
    });
}(window));
function convertSubject(subject){
    function UpperLower(subjectA){
        return subjectA.substr(0,1).toUpperCase() + subjectA.substr(1).toLowerCase();
    }

    if (subject.toUpperCase() == "TOK"){
        return "TOK";
    }

    var subjects = subject.split(" ");

    var returnVal = "";

    for (var i = 0; i < subjects.length; i++){
        var oneSubject = UpperLower(subjects[i]);
        returnVal += oneSubject + " ";
    }

    returnVal = returnVal.substr(0, returnVal.length-1);

    return returnVal;
}
// Part III ends
