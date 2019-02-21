Planck.Extension.EntityEditor.View.Component.EntityEditor = function(container)
{
    //this.entity = entity;

    this.$container = $(container);

};

Planck.Extension.EntityEditor.View.Component.EntityEditor.prototype.setEntity = function(entity)
{
    this.entity = entity;
};





Planck.Extension.EntityEditor.View.Component.EntityEditor.prototype.load = function()
{


    var componentLoader = new Planck.Extension.ViewComponent.RemoteComponentLoader('Planck\\Extension\\EntityEditor\\View\\Component\\EntityEditor');
    componentLoader.addMethodCall(
        'loadEntityByAttributes',
        [
            this.entity.getType(),
            this.entity.getValues(true)
        ]
    );

    componentLoader.load(function(componentLoaderDescriptor) {

        this.renderEntityEditor(
            componentLoaderDescriptor.getHTML()
        );
    }.bind(this));
};




Planck.Extension.EntityEditor.View.Component.EntityEditor.prototype.renderEntityEditor = function(content)
{


    this.$container.html(content);


    this.$container.find('.plk-entity-chooser').each(function(index, element) {



        var entityName = $(element).attr('data-entity-type');

        if(isset(Planck.Extension.EntityEditor.entityMapping[entityName])) {
            var component = new Planck.Extension.EntityEditor.entityMapping[entityName](element);
        }
        else {
            var component = new Planck.Extension.EntityEditor.View.Component.EntityChooser(element);
        }
    });
};

