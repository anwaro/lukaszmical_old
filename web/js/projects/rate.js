/**
 * Created by lukasz on 07.10.16.
 */

$(function() {
    $(".rating span").click(function () {
        var el = $(this);
        el.parent().find("span").removeClass('rate');
        var project_id = parseInt(el.data('project'));
        var rate = parseInt(el.data('rate'));
        vote(project_id, rate);
        el.addClass('rate');
    });


    var data =getCookie('rate');
    for(var id in data){
        $("#rate-" + id + "-" + data[id].rate).addClass('rate');
    }
});

function vote(project_id, rate){
    var id = checkCookie(project_id);
    var data = {"rate":rate, "project_id":project_id};
    var url = "/projects/vote/";
    if(id){
        url = "/projects/updateVote/";
        data.id = id;
    }
    $$.post(url,{
        data:data,
        success: function(data){
            data = JSON.parse(data);
            if(typeof data.id){
                setCookie(data.project_id, data.rate, data.id);
            }
        }
    })
}


function checkCookie(project_id){
    var data =getCookie('rate');
    if(typeof data[project_id] != 'undefined'){
        return data[project_id].id;
    }
    return false;
}

function setCookie(project_id, rate, id){
    var newRate = {"rate":rate, "id":id};
    var data =getCookie('rate');
    data[project_id] = newRate;
    $$.cookie('rate', JSON.stringify(data), 366);
}

function getCookie(key){
    var data =$$.cookie(key) || '{}';
    return JSON.parse(data);
}

function projectStart(){

}