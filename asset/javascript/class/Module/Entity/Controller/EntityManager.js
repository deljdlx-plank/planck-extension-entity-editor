Planck.Extension.EntityEditor.Module.Entity.Controller.EntityManager = function(container)
{

    this.$container = $(container);
    this.$entityEditorContainer = this.$container.find('.plk-entity-editor-container');


    this.$entityListContainer = this.$container.find('.plk-entity-list-container');

    this.entityList;
    this.entityEditor;
};


Planck.Extension.EntityEditor.Module.Entity.Controller.EntityManager.prototype.initialize = function()
{

    this.entityList = new Planck.Extension.EntityEditor.View.Component.EntityList(this.$entityListContainer);
    this.entityList.on('itemClick', function(entityDescriptor) {

        this.loadEditorByEntityDescriptor(entityDescriptor);

    }.bind(this));


    this.entityList.load();

    this.renderEntityEditor();

};

Planck.Extension.EntityEditor.Module.Entity.Controller.EntityManager.prototype.loadEditorByEntityDescriptor = function(descriptor)
{

    var componentLoader = new Planck.Extension.ViewComponent.RemoteComponentLoader('Planck\\Extension\\EntityEditor\\View\\Component\\EntityEditor');
    componentLoader.addMethodCall(
        'loadEntityByAttributes',
        [
            descriptor.type,
            descriptor.entity
        ]
    );

    componentLoader.load(function(componentLoaderDescriptor) {

        this.renderEntityEditor(
            componentLoaderDescriptor.getHTML()
        );
        /*
        $('.plk-entity-editor-container').html(

        );
        */


    }.bind(this));
};


Planck.Extension.EntityEditor.Module.Entity.Controller.EntityManager.prototype.loadEditor = function(entityType, id)
{


    return;
};






Planck.Extension.EntityEditor.Module.Entity.Controller.EntityManager.prototype.renderEntityEditor = function(content)
{


    this.$entityEditorContainer.html(content);


    this.$entityEditorContainer.find('.plk-entity-chooser').each(function(index, element) {

        var entityName = $(element).attr('data-entity-type');

        if(isset(Planck.Extension.EntityEditor.entityMapping[entityName])) {
            var component = new Planck.Extension.EntityEditor.entityMapping[entityName](element);
        }
        else {
            var component = new Planck.Extension.EntityEditor.View.Component.EntityChooser(element);
        }
    });
};


