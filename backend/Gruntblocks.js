'use strict';
 
module.exports = function(processor) {
    
    processor.registerBlockType('laraveljs', function (content, block, blockLine, blockContent) {
        var js = blockContent.match(/'.+'/g);
        var src = [];
        
        js.forEach(function(path) {
            src.push('public/' + path.substring(1).substring(0, path.length-2));
        });
        
        processor.options.config('concat.js.files', [{dest: '.tmp/concat/js/abclandia.js', src: src}]);
        
        return content.replace(blockLine, "{{ HTML::script('"+block.asset+"'); }}");
    });
    
    processor.registerBlockType('laravelcss', function (content, block, blockLine, blockContent) {
        var css = blockContent.match(/'.+'/g);
        var src = [];
        
        css.forEach(function(path) {
            src.push('public/' + path.substring(1).substring(0, path.length-2));
        });
        
        processor.options.config('concat.css.files', [{dest: '.tmp/concat/css/abclandia.css', src: src}]);
        
        return content.replace(blockLine, "{{ HTML::style('"+block.asset+"'); }}");
    });
    
    processor.registerBlockType('so', function (content, block, blockLine, blockContent) {
        if (processor.options.so === block.asset) {
            return content;
        } else { 
            return content.replace(blockLine, '');
        }
    });
};