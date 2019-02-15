
Planck.Extension.EntityEditor = {};
Planck.Extension.EntityEditor.View = {};
Planck.Extension.EntityEditor.View.Component = {};
Planck.Extension.EntityEditor.Module = {};
Planck.Extension.EntityEditor.Model = {};
Planck.Extension.EntityEditor.Model.Entity = {};
Planck.Extension.EntityEditor.Model.Repository = {};


/*
Planck.Extension.EntityEditor.View.Component.FakeManager = function(triggerElement)
{
   $(triggerElement).click(function() {
       console.log('clicked on entity chooser trigger');
   });
};
*/



Planck.Extension.EntityEditor.entityMapping = {
    //'Planck\\Extension\\Content\\Model\\Entity\\Image' : Planck.Extension.EntityEditor.View.Component.FakeManager
};


Planck.Extension.EntityEditor.initialize = function()
{
   $('.plk-entity-chooser').each(function(index, element) {


       var entityName = $(element).attr('data-entity-type');



       if(isset(Planck.Extension.EntityEditor.entityMapping[entityName])) {

           console.log('custom manager')

            var component = new Planck.Extension.EntityEditor.entityMapping[entityName](element);

       }
       else {
           var component = new Planck.Extension.EntityEditor.View.Component.EntityChooser(element);
       }




   });
};