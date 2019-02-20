Planck.Extension.EntityEditor.View.Component.EntityChooser = function(triggerElement)
{

    this.model = new Planck.Model();


    this.$triggerElement = $(triggerElement);
    this.$triggerElement.hide();

    this.$label = this.getLabel();
    this.$label.html(i18n('<div class="button" data-behaviour="interactive"><span>'+this.$label.html()+'</span></div>'));


    this.$inputValue = $('<input name="'+this.$triggerElement.attr('name')+'" value="'+this.$triggerElement.val()+'" type="hidden"/>');
    this.$triggerElement.parent().append(this.$inputValue);

    this.$labelElement = $('<input readonly="readonly" data-behaviour="interactive"/>');
    this.$triggerElement.parent().append(this.$labelElement);


    this.entityType = this.$triggerElement.attr('data-entity-type');



    this.$label.click(function() {
        this.showEntitySelector();
    }.bind(this));

    this.$labelElement.click(function() {
        this.showEntitySelector();
    }.bind(this));


    this.loadPreview(this.$inputValue.val());



};


Planck.Extension.EntityEditor.View.Component.EntityChooser.prototype.loadPreview = function(value)
{
    if(!value) {
        return false;
    }


    var url = '?/@extension/planck-extension-entity_editor/entity/api[get]';
    var data = {
        entity: this.entityType,
        id: value
    };
    Planck.ajax({
        url: url,
        method: 'get',
        data: data,
        success: function(response) {

            var entity = this.model.getEntityByDescriptor(response);

            this.$labelElement.val(
               entity.getLabel()
            );

        }.bind(this)
    });




};



Planck.Extension.EntityEditor.View.Component.EntityChooser.prototype.getFloatingBox = function(descriptor)
{

    var $element = $(descriptor.getHTML());

    var floatingBox = new Planck.Extension.ViewComponent.View.Component.FloatingBox(
        this.$label,
        $element
    );
    return floatingBox;

};


Planck.Extension.EntityEditor.View.Component.EntityChooser.prototype.showEntitySelector = function()
{

    var componentName = 'Planck\\Extension\\EntityEditor\\View\\Component\\EntityList';

    var componentLoader = new Planck.Extension.ViewComponent.RemoteComponentLoader(
        componentName
    );

    componentLoader.addMethodCall('loadRepositoryByEntityName', [
        this.entityType
    ]);

    componentLoader.load(function(descriptor) {

        var $floatingBox  = this.getFloatingBox(descriptor);
        $floatingBox.show();



        var list = new Planck.Extension.EntityEditor.View.Component.EntityList(
            $floatingBox.getElement()
        );

        list.on('itemClick', function(descriptor) {
            this.$inputValue.val(descriptor.entity.getId());
            this.$labelElement.val(descriptor.entity.getLabel());
            $floatingBox.destroy();
        }.bind(this));
        list.load(0, function() {
        }.bind(this));

    }.bind(this));



};


Planck.Extension.EntityEditor.View.Component.EntityChooser.prototype.getLabel = function()
{
    return this.$triggerElement.parents('.plk-field-container').find('label');
};
