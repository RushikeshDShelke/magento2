// Generated by CoffeeScript 1.9.3

angular.module('mp.blog.layout', ['ngDraggable']).directive('mpLayoutElement', function() {
  return {
    restrict: 'C',
    templateUrl: 'layout/element.html',
    controller: 'LayoutController',
    scope: {
      mpName: '@',
      mpId: '@',
      mpValue: '@',
      mpConfig: '@'
    }
  };
}).directive('mpLayoutColumn', function() {
  return {
    restrict: 'C',
    templateUrl: 'layout/column.html',
    scope: true
  };
}).controller('LayoutController', [
  "$scope", function($scope) {
    $scope.config = JSON.parse($scope.mpConfig);
    $scope.value = JSON.parse($scope.mpValue);
    $scope.name = $scope.mpName;
    $scope.id = $scope.mpId;
    $scope.drag = false;
    $scope.adding = false;
    $scope.available = {
      content: [],
      sidebar: []
    };
    $scope.initValue = function() {
      if (!$scope.value.layout) {
        $scope.value.layout = false;
      }
      if (!$scope.value.left_side) {
        $scope.value.left_side = [];
      }
      if (!$scope.value.right_side) {
        $scope.value.right_side = [];
      }
      if (!$scope.value.content) {
        $scope.value.content = [];
      }
      return $scope;
    };
    $scope.refreshAvailable = function(type) {
      $scope.available[type] = [];
      angular.forEach($scope.config[type], function(block) {
        if (type === 'content') {
          if ($scope.getBlockId('content', block.value) === false) {
            $scope.available[type].push(block);
          }
        } else if (type === 'sidebar') {
          if (($scope.getBlockId('left_side', block.value) === false) && ($scope.getBlockId('right_side', block.value) === false)) {
            $scope.available[type].push(block);
          }
        }
      });
      return $scope;
    };
    $scope.getSelectedLabel = function() {
      return $scope.config.layouts[$scope.value.layout];
    };
    $scope.setLayout = function(layout) {
      $scope.value.layout = layout;
      $scope.adding = false;
      if (layout === 'two-columns-left') {
        angular.forEach($scope.value['right_side'], function(el) {
          return $scope.value['left_side'].push(el);
        });
        $scope.value['right_side'] = [];
      } else if (layout === 'two-columns-right') {
        angular.forEach($scope.value['left_side'], function(el) {
          return $scope.value['right_side'].push(el);
        });
        $scope.value['left_side'] = [];
      } else if (layout === 'one-column') {
        $scope.value['left_side'] = [];
        $scope.value['right_side'] = [];
      }
      $scope.refreshAvailable('content');
      $scope.refreshAvailable('sidebar');
      return false;
    };
    $scope.displayLeftSidebar = function() {
      return ($scope.value.layout === 'two-columns-left') || ($scope.value.layout === 'three-columns');
    };
    $scope.displayRightSidebar = function() {
      return ($scope.value.layout === 'two-columns-right') || ($scope.value.layout === 'three-columns');
    };
    $scope.showVariantsForColumn = function(type) {
      $scope.adding = type;
    };
    $scope.isActive = function(layout) {
      return $scope.value.layout === layout;
    };
    $scope.displayAddButton = function(type, subtype) {
      return $scope.available[type].length && ($scope.adding !== subtype);
    };
    $scope.getBlockLabel = function(type, name) {
      var result;
      result = false;
      angular.forEach($scope.config[type], (function(block) {
        if (name === block.value) {
          return result = block.label;
        }
      }).bind(result));
      return result;
    };
    $scope.getBackendImage = function(type, name) {
      var result;
      result = false;
      angular.forEach($scope.config[type], (function(block) {
        if (name === block.value) {
          return result = block.backend_image;
        }
      }).bind(result));
      return result;
    };
    $scope.getBlockId = function(subtype, name) {
      var result;
      result = false;
      angular.forEach($scope.value[subtype], (function(el, index) {
        if (el === name) {
          return result = index;
        }
      }).bind(result));
      return result;
    };
    $scope.removeBlock = function(subtype, index) {
      if (confirm($scope.config.delete_message)) {
        $scope.value[subtype].splice(index, 1);
      }
      $scope.refreshAvailable('content').refreshAvailable('sidebar');
      return $scope;
    };
    $scope.addToColumn = function(type, block) {
      $scope.value[type].push(block);
      $scope.adding = false;
      return $scope.refreshAvailable('content').refreshAvailable('sidebar');
    };
    $scope.onDragBegin = function(data, attrs) {
      $scope.drag = {
        type: attrs.ngType,
        block: data
      };
      return $scope;
    };
    $scope.onDragCancel = function(data, attrs) {
      $scope.drag = false;
    };
    $scope.onDropSuccess = function(data, attrs, oAttrs) {
      var indexToInsert, indexToRemove;
      $scope.drag = false;
      indexToInsert = false;
      indexToRemove = $scope.getBlockId(oAttrs.ngSubType, data);
      if (indexToRemove !== false) {
        $scope.value[oAttrs.ngSubType].splice(indexToRemove, 1);
      }
      if (typeof attrs.ngDropData !== 'undefined') {
        indexToInsert = $scope.getBlockId(attrs.ngSubType, attrs.ngDropData);
        if (indexToInsert !== false) {
          if (indexToInsert === $scope.value[attrs.ngSubType].length) {
            $scope.value[attrs.ngSubType].push(data);
          } else {
            $scope.value[attrs.ngSubType].splice(indexToInsert + 1, 0, data);
          }
        } else {
          $scope.value[attrs.ngSubType].splice(0, 0, data);
        }
      } else {
        $scope.value[attrs.ngSubType].splice(0, 0, data);
      }
    };
    $scope.isMyDrag = function(type, block) {
      var result;
      result = $scope.drag.type === type;
      if (typeof block !== 'undefined') {
        return result && ($scope.drag.block !== block);
      }
      return result;
    };
    $scope.initValue().refreshAvailable('content').refreshAvailable('sidebar');
  }
]);
