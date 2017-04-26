/**
 * Created by dmetthey.stage on 25/04/2017.
 */
/**
 * Created by dmetthey.stage on 25/04/2017.
 */
var $collectionHolder;

//setup an "add a user" link
var $addUserLink = $('<a href="#" class="add_user_link btn btn-primary"><i class="fa fa-plus-circle"></i> Ajouter un utilisateur</a>');
var $newLinkDiv = $('<div></div>').append($addUserLink);

$(document).ready(function () {
    //Get the ul that holds the collection of users
    $collectionHolder = $('div#authbundle_equipe_teamRoles');

    //add a delete link to all of the existing tag form div
    $collectionHolder.find('div.user').each(function () {
        addUserFormDeleteLink($(this));
    });
    //add "add a user" anchor and li to the users ul
    $collectionHolder.append($newLinkDiv);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addUserLink.on('click', function (e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addUserForm($collectionHolder, $newLinkDiv);
    })

});
function addUserForm($collectionHolder, $newLinkDiv) {
    //Get the data prototype
    var prototype = $collectionHolder.data('prototype');

    //Get thenew index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormDiv = $('<div class="row"></div>').append(newForm);
    $newLinkDiv.before($newFormDiv);

    //add a delete link to the new form
    addUserFormDeleteLink($newFormDiv);
}
// Add a delete link on each User
function addUserFormDeleteLink($tagFormDiv) {
    var $removeFormA = $('<a href=# class="equipe_form_delete btn btn-danger"><i class="fa fa-minus-circle"></i> Supprimer</a>');
    $tagFormDiv.append($removeFormA);

    $removeFormA.on('click', function (e)
    {
        //prevent the link from creating a # on the URl
        e.preventDefault();

        //remove the User from the form
        $tagFormDiv.remove();
    })
}