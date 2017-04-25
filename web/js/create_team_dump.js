/**
 * Created by dmetthey.stage on 25/04/2017.
 */
var $collectionHolder;

//setup an "add a user" link
var $addUserLink = $('<a href="#" class="add_user_link">Ajouter un utilisateur</a>');
var $newLinkLi = $('<li></li>').append($addUserLink);

$(document).ready(function () {
    //Get the ul that holds the collection of users
    $collectionHolder = $('ul.userRoles');

    //add "add a user" anchor and li to the users ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addUserLink.on('click', function (e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addUserForm($collectionHolder, $newLinkLi);
    })

});
function addUserForm($collectionHolder, $newLinkLi) {
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
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
}