/* eslint-disable */

// from https://github.com/d3/d3-plugins with custom modifications from our side
// to fix heights and ordering of nodes and links as well as out nodes and summary nodes

export default function (d3) {
  d3.sankey = function () {

    function isOutNode(name) {
      return name && name === '_out_';
    }

    function isSummaryNode(node) {
      return node.isSummaryNode;
    }

    var sankey = {},
      nodeWidth = 24,
      nodePadding = 8,
      size = [1, 1],
      nodes = [],
      links = [];

    sankey.nodeWidth = function (_) {
      if (!arguments.length) return nodeWidth;
      nodeWidth = +_;
      return sankey;
    };

    sankey.nodePadding = function (_) {
      if (!arguments.length) return nodePadding;
      nodePadding = +_;
      return sankey;
    };

    sankey.nodes = function (_) {
      if (!arguments.length) return nodes;
      nodes = _;
      return sankey;
    };

    sankey.links = function (_) {
      if (!arguments.length) return links;
      links = _;
      return sankey;
    };

    sankey.size = function (_) {
      if (!arguments.length) return size;
      size = _;
      return sankey;
    };

    sankey.layout = function (iterations) {
      computeNodeLinks();
      computeNodeValues();
      computeNodeBreadths();
      computeNodeDepths(iterations);
      computeLinkDepths();
      return sankey;
    };

    sankey.relayout = function () {
      computeLinkDepths();
      return sankey;
    };

    sankey.link = function () {
      var curvature = .5;

      function link(d) {
        if (isOutNode(d.target.name)) {
          // we only show a square for exits
          var x0 = d.source.x + d.source.dx,
            y0 = d.source.y + d.sy + d.dy / 2;
          /**
           *
           return "M" + x0 + "," + (y0)
           + " V" + y0 + 15
           + " H " + (x0 + 15);
           */
          return "M" + x0 + "," + (y0)
            + " L" + (x0 + 15) + "," + (y0);
        }
        var x0 = d.source.x + d.source.dx,
          x1 = d.target.x,
          xi = d3.interpolateNumber(x0, x1),
          x2 = xi(curvature),
          x3 = xi(1 - curvature),
          y0 = d.source.y + d.sy + d.dy / 2,
          y1 = d.target.y + d.ty + d.dy / 2;
        return "M" + x0 + "," + y0
          + "C" + x2 + "," + y0
          + " " + x3 + "," + y1
          + " " + x1 + "," + y1;
      }

      link.curvature = function (_) {
        if (!arguments.length) return curvature;
        curvature = +_;
        return link;
      };

      return link;
    };

    function computeNodeLinks() {
      nodes.forEach(function (node) {
        node.sourceLinks = [];
        node.targetLinks = [];
      });
      links.forEach(function (link) {
        var source = link.source,
          target = link.target;
        if (typeof source === 'number') source = link.source = nodes[link.source];
        if (typeof target === 'number') target = link.target = nodes[link.target];
        source.sourceLinks.push(link);
        target.targetLinks.push(link);
      });
    }

    function computeNodeValues() {
      nodes.forEach(function (node) {
        node.value = Math.max(
          d3.sum(node.sourceLinks, value),
          d3.sum(node.targetLinks, value)
        );
      });
    }

    function computeNodeBreadths() {
      var x = 0;

      nodes.forEach(function (node) {
        node.x = node.depth;
        node.dx = nodeWidth;
        if (node.depth > x) {
          x = node.depth;
        }
      });

      scaleNodeBreadths((size[0] - nodeWidth) / (x));
    }

    function moveSourcesRight() {
      nodes.forEach(function (node) {
        if (!node.targetLinks.length) {
          node.x = d3.min(node.sourceLinks, function (d) {
            return d.target.x;
          }) - 1;
        }
      });
    }

    function scaleNodeBreadths(kx) {
      nodes.forEach(function (node) {
        node.x *= kx;
      });
    }

    function computeNodeDepths(iterations) {
      var nodesByBreadth = d3.nest()
        .key(function (d) {
          return d.x;
        })
        .sortKeys(d3.ascending)
        .entries(nodes)
        .map(function (d) {
          return d.values;
        });

      //
      initializeNodeDepth();
      resolveCollisions();
      for (var alpha = 1; iterations > 0; --iterations) {
        relaxRightToLeft(alpha *= .99);
        resolveCollisions();
        relaxLeftToRight(alpha);
        resolveCollisions();
      }

      function initializeNodeDepth() {
        var ky = d3.min(nodesByBreadth, function (nodes) {
          var sumNodes = d3.sum(nodes, value);
          if (!sumNodes) {
            return 0;
          }
          return (size[1] - (nodes.length - 1) * nodePadding) / sumNodes;
        });

        nodesByBreadth.forEach(function (nodes) {
          nodes.forEach(function (node, i) {
            node.y = i;
            node.dy = node.value * ky;

            if (isSummaryNode(node)) {
              //  we also need to scale the links in this case
              node.sourceLinks.forEach(function (link) {
                link.scaleNodeDy = 25 / node.dy;
                link.scaleNodeMax = 25;
              });
              node.dy = 25;
              return;
            }

            if (node.dy < 4) {
              //  we also need to scale the links in this case
              node.sourceLinks.forEach(function (link) {
                link.scaleNodeDy = 4 / node.dy;
                link.scaleNodeMax = 4;
              });

              node.dy = 4;
            }
          });
        });

        links.forEach(function (link) {
          link.dy = link.value * ky;
          if (link.scaleNodeDy) {
            link.dy *= link.scaleNodeDy
          }
          if (link.scaleNodeMax && link.dy > link.scaleNodeMax) {
            link.dy = link.scaleNodeMax;
          }
        });
      }

      function relaxLeftToRight(alpha) {
        nodesByBreadth.forEach(function (nodes, breadth) {
          nodes.forEach(function (node) {
            if (node.targetLinks.length) {
              var y = d3.sum(node.targetLinks, weightedSource) / d3.sum(node.targetLinks, value);
              node.y += (y - center(node)) * alpha;
            }
          });
        });

        function weightedSource(link) {
          return center(link.source) * link.value;
        }
      }

      function relaxRightToLeft(alpha) {
        nodesByBreadth.slice().reverse().forEach(function (nodes) {
          nodes.forEach(function (node) {
            if (node.sourceLinks.length) {
              var y = d3.sum(node.sourceLinks, weightedTarget) / d3.sum(node.sourceLinks, value);
              node.y += (y - center(node)) * alpha;
            }
          });
        });

        function weightedTarget(link) {
          return center(link.target) * link.value;
        }
      }

      function resolveCollisions() {
        nodesByBreadth.forEach(function (nodes) {
          var node,
            dy,
            y0 = 0,
            n = nodes.length,
            i;

          // Push any overlapping nodes down.
          for (i = 0; i < n; ++i) {
            node = nodes[i];
            dy = y0 - node.y;
            if (dy > 0) node.y += dy;
            y0 = node.y + node.dy + nodePadding;
          }

          // push it back up if the bottommost node goes outside the bounds
          /* removed by us, we do not want to push them back up
          dy = y0 - nodePadding - size[1];
          if (dy > 0) {
              y0 = node.y -= dy;

              // Pushin back up any overlapping nodes.
              for (i = n - 2; i >= 0; --i) {
                  node = nodes[i];
                  dy = node.y + node.dy + nodePadding - y0;
                  if (dy > 0) node.y -= dy;
                  y0 = node.y;
              }
          }
          */
        });
      }

      function ascendingDepth(a, b) {
        return a.y - b.y;
      }

    }

    function computeLinkDepths() {
      nodes.forEach(function (node) {
        node.sourceLinks.sort(ascendingTargetDepth);
        node.targetLinks.sort(ascendingSourceDepth);
      });
      nodes.forEach(function (node) {
        var sy = 0, ty = 0;
        node.sourceLinks.forEach(function (link) {
          link.sy = sy;
          sy += link.dy;
        });
        node.targetLinks.forEach(function (link) {
          link.ty = ty;
          ty += link.dy;
        });
      });

      function ascendingSourceDepth(a, b) {
        return a.source.y - b.source.y;
      }

      function ascendingTargetDepth(a, b) {
        return a.target.y - b.target.y;
      }
    }

    function center(node) {
      return 0;
    }

    function value(link) {
      return link.value;
    }

    return sankey;
  };
};
