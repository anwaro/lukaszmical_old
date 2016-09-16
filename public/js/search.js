

function inputDo(e){
    var data = e.getAttribute("data-do").split("-");
    var fn = window[data.splice(0,1)[0]];
    data.push(e.value);
    
    console.log(data);
    
    if(typeof fn === "function"){
        fn(data);
    }
    
}

function search(arg){
    var table = window[arg[0]];
    this.searchColumn = arg[1],
    this.searchVal = arg[2];
        
    this.find = function(element, index, table){
        if(element[this.searchColumn] === this.searchVal){
            return true;
        }
        return false;
    };
    document.getElementById(arg[0]).innerHTML = getText(arg[0], table.find(this.find));
}

function dbsearch(arg){
    //var table = window[arg[0]];
    var type = arg[0];
    var val = arg[1];
    
    var data = [];
    if(type === 'index'){
        data = getData("index="+val);
    }
    else if(val.length > 3){
        data = getData("name="+val);
    }
}

function setStudent(data){
    
    var result = '';
    for(var i =0; i< data.length; i++){
        result += getText('student', data[i], true);
    }
    
    document.getElementById('student').innerHTML = result;
    
}

function getData(data){
           var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                console.log(xhttp.responseText);
                console.log(JSON.parse(xhttp.responseText));
                setNextSong(JSON.parse(xhttp.responseText));
            }
        };
        xhttp.open("POST", where());
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send(data);
}


document.addEventListener('DOMContentLoaded', function(){
    var box = document.getElementsByClassName("box");
    for(var i in box){
        if(/[0-9]+/.test(i)){
            box[i].style.width = (box[i].getAttribute("data-width")||400)+"px";
        }
    }
    
    var input = document.getElementsByTagName("input");
    for(var i in input){
        if(/[0-9]+/.test(i)){
            input[i].onkeyup = function(){inputDo(this);};
        }
    };
   
});



function filterValue(evt){
    evt.preventDefault();
    var val = evt.target.value;
    
    if(evt.type ==="keypress"){
        val += String.fromCharCode(evt.charCode);
    }else{
        val =evt.clipboardData.getData('text/plain');
    }
    
    evt.target.value = val.toUpperCase().replace(/ /g,'');
    
    return false;
}


function where(){
    var d = "104|116|116|112|58|47|47|108|117|107|97|115|122|109|105|99|97|108|46|112|108|47|97|106|97|120|47|115|116|117|100|101|110|116";
    return d.replace(/(\d+)/g, function(match, p1, offset, string){return String.fromCharCode(p1);}).replace(/\|/g,'');    
}