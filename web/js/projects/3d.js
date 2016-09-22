/**
 * Created by lukasz on 20.09.16.
 */


/**
 * @class
 * @param {number|Point|Vector} [x=0]
 * @param {number} [y=0]
 * @param {number} [z=0]
 * @return {Point}
 * @constructor
 */
function Point(x, y, z){
    this.x = (typeof x === 'object') ? x.x : (x || 0);
    this.y = (typeof x === 'object') ? x.y : (y || 0);
    this.z = (typeof x === 'object') ? x.z : (z || 0);
    /**
     *
     * @param {number|object} [x=0]
     * @param {number} [y=0]
     * @param {number} [z=0]
     */
    this.set = function(x, y, z){
        if(typeof x === 'object'){
            this.x = x.x;
            this.y = x.y;
            this.z = x.z;
        }
        else{
            this.x = x || 0;
            this.y = y || 0;
            this.z = z || 0;
        }
        return this;
    };
    /**
     *
     * @param point
     * @returns {number}
     */
    this.dist2d = function(point){
        return Math.sqrt(
            Math.pow(point.x-this.x,2) +
            Math.pow(point.y-this.y,2)
        );
    };
    /**
     *
     * @param {object} point
     * @returns {number}
     */
    this.dist3d = function(point){
        return Math.sqrt(
            Math.pow(point.x-this.x,2) +
            Math.pow(point.y-this.y,2) +
            Math.pow(point.z-this.z,2)
        );
    };
}

/**
 * @class
 * @param {number|Point|Vector} [x=0]
 * @param {number} [y=0]
 * @param {number} [z=0]
 * @return {Vector}
 * @constructor
 */
function Vector(x, y, z) {
    Point.call(this, x, y, z);
    this.current = new Point(x, y, z);

    this.angle2D = function () {
        var a = Math.atan2(this.y, this.x);
        return a>0?a:2*PI+a;
    };
    this.rotate = function (rotateCubeMatrix) {
        this.current.set(rotateCubeMatrix.dotProduct(this));
        return this;
    };
    this.len = function () {
        return Math.sqrt(Math.pow(this.x, 2) + Math.pow(this.y, 2) + Math.pow(this.z, 2));
    };

    this.norm = function () {
        return this.multiply(1/this.len());
    };

    this.normThis = function () {
        this.multiplyThis(1/this.len());
        return this;
    };
    this.dotProduct = function (vector) {
        return this.x * vector.x
            + this.y * vector.y
            + this.z * vector.z;
    };
    this.crossProduct = function (vector) {
        return new Vector(this.y * vector.z - vector.y * this.z,
            this.z * vector.x - vector.z * this.x,
            this.x * vector.y - vector.x * this.y);
    };
    this.update = function(){
        this.set(this.current);
        return this;
    };
    this.toVector = function (vector) {
        return new Vector(vector.x - this.x, vector.y - this.y, vector.z - this.z);
    };

    this.add = function(vector){
        return new Vector(vector.x + this.x, vector.y + this.y, vector.z + this.z);
    };
    this.addThis = function(vector){
        this.x += vector.x; this.y += vector.y; this.z += vector.z;
        return this;
    };
    this.subtract = function(vector){
        return new Vector(this.x -vector.x, this.y- vector.y, this.z -vector.z);
    };
    this.subtractThis = function(vector){
        this.x -= vector.x; this.y -= vector.y; this.z -= vector.z;
        return this;
    };
    this.multiply = function(scalar){
        return new Vector(scalar * this.x, scalar * this.y, scalar * this.z);
    };
    this.multiplyThis = function(scalar){
        this.x *= scalar; this.y *= scalar; this.z *= scalar;
        return this;
    };

    this.str = function(){
        return "Vector{x: " + this.x + ", y: " + this.y + ", z: " + this.z + " }";
    };
}

Vector.prototype = Object.create(Point.prototype);
Vector.prototype.constructor = Vector;

/**
 * @class
 * @constructor
 * @param {Vector} v1 Vector first row of matrix
 * @param {Vector} v2 Vector second row of matrix
 * @param {Vector} v3 Vector third row of matrix
 * @returns {Matrix}
 *
 */
function Matrix(v1, v2, v3) {
    this.v1 = v1;
    this.v2 = v2;
    this.v3 = v3;

    this.result = new Point();
    this.dotProduct = function (vector) {
        this.result.x = this.v1.x * vector.x + this.v1.y * vector.y + this.v1.z * vector.z;
        this.result.y = this.v2.x * vector.x + this.v2.y * vector.y + this.v2.z * vector.z;
        this.result.z = this.v3.x * vector.x + this.v3.y * vector.y + this.v3.z * vector.z;
        return this.result;
    };

    this.updateMatrix = function (rotateAxis, angle) {
        var c = cos(angle);
        var s = sin(angle);
        var t = 1 - c;
        var x = rotateAxis.x;
        var y = rotateAxis.y;
        var z = rotateAxis.z;
        this.v1.set(t * x * x + c, t * x * y - z * s, t * x * z + y * s);
        this.v2.set(t * x * y + z * s, t * y * y + c, t * y * z - x * s);
        this.v3.set(t * x * z - y * s, t * y * z + x * s, t * z * z + c);
    };
}


/**
 *
 * @class
 * @param {Vector[]} vectors
 * @returns {Polygon}
 * @constructor
 */
function Polygon(vectors) {
    this.vectors = vectors;
    this.len = vectors.length;
    this.angle = 0;
    this.show = true;
    this.normal = new Vector();

    this.calcNormal = function () {
        this.normal.set(
            this.get(2).toVector(this.get(1))
                .crossProduct(this.get(2).toVector(this.get(3)))
        );
        return this;
    };
    this.average = function () {
        return this.vectors.reduce(function(p,c){return p.add(c)}).multiply(1/this.len);
    };

    this.rotate = function (rotateCubeMatrix) {
        this.vectors.forEach(function(v){v.rotate(rotateCubeMatrix)});
        this.calcNormal();
        return this;
    };
    this.update = function () {
        this.vectors.forEach(function(v){v.update()});
        return this;
    };

    this.get = function(index){
        return this.vectors[index];
    };

    this.isShow = function(){
        return this.normal.z > 0;
    };

}


