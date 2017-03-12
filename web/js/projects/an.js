function _an(action, value){

    var tab = {
        act: false,
        val: {
            act: 0,
            ina: 0,
            tot: 0,
            ti: 1 * new Date()
        }
    };
    tab.set = function(key, val){
        this.val[key] = val;
    };
    tab.get = function (key) {
        return this.val[key];
    };
    tab.add = function (key) {
        this.val[key] += 1 * new Date - this.val[ti];
    };
    tab.active = function () {
        this.act = true;
        this.add('in');
    };
    tab.inactive = function () {
        this.act = false;
        this.add('act');
    };

    function as(){

    }
    function register(id){
        this.id = id;
    }

    return this
}