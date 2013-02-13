var w = 600,
    h = 600,
    r = Math.min(w, h) / 2, 
    color = get_random_colors(100),
    arc = d3.svg.arc().outerRadius(r),
    donut = d3.layout.pie().value(function(d) { return d.value; });

var svg = d3.select("#results").selectAll("svg").data([sourceData]);
svg.enter().append("svg")
  .attr("width", w)
  .attr("height", h);

var arcs = svg.selectAll("g.arc")
  .data(donut);
arcs.enter().append("g")
    .attr("class", "arc")
    .attr("transform", "translate("+r+","+r+")");//.exit().remove(); 
arcs.exit().remove();
arcs.selectAll("text").remove();
arcs.selectAll("path").remove();


var paths = arcs.append("path")
    .attr("fill", function(d, i) { return color(i); })
    .attr("d", arc);


arcs.append("text")
  .attr("transform", 
    function(d) {
      d.innerRadius = 0;
      d.outerRadius = r;
      console.log(d);
      var midAngle = ((d.endAngle - d.startAngle) / 2) + d.startAngle;
if(midAngle <= Math.PI) {
  rotationAngle = -90;
} else {
  rotationAngle = 90;
}
midAngle = midAngle * 180 / Math.PI;
      return "translate("+arc.centroid(d)+")rotate("+(midAngle+rotationAngle)+")";
    })
  .attr("dy", ".35em")
  .attr("text-anchor", "middle")
  .text(function(d,i) { return sourceData[i].label + " (" + sourceData[i].value + ")"; });


/*var paths = arcs.append("path")
    .attr("fill", function(d, i) { return color(i); })
    .attr("d", arc);
*/
paths.transition()
    .ease("bounce")
    .duration(2000)
    .attrTween("d", tweenPie);

/*paths.transition()
    .ease("elastic")
    .delay(function(d, i) { return 2000 + i * 50; })
    .duration(750)
    .attrTween("d", tweenDonut);
*/
function tweenPie(b) {
  b.innerRadius = 0;
  var i = d3.interpolate({startAngle: 0, endAngle: 0}, b); 
  return function(t) {
    return arc(i(t));
  };
}

/*function tweenDonut(b) {
  b.innerRadius = r * .6; 
  var i = d3.interpolate({innerRadius: 0}, b); 
  return function(t) {
    return arc(i(t));
  };
}*/


function get_random_colors(numColors) {

    var colorArray = [];

    var letters = '0123456789ABCDEF'.split('');
    var color = '#';

    for(var a = 0; a < numColors; a++) {
      color = '#';
      for (var i = 0; i < 6; i++ ) {
          color += letters[Math.round(Math.random() * 15)];
      }
      colorArray.push(color);
    }
    return d3.scale.ordinal().range(colorArray)
}
