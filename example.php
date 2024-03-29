<?php

// Just keeping this around to help drive ideas in future development, the code will no longer work or be maintained

function scenario4_named_relationship($builder, $relatedBuilder)
{
    $builder
        ->relate($relatedBuilder, 'timezone')
        ->flush();
}

function scenario5_implied_relationship($builder, $relatedBuilder)
{
    $builder
        ->relate($relatedBuilder)
        ->flush();
}

function scenario6_complex_state($builder)
{
    // state introduces a related entity
    $builder
        ->state('valid_utc')
        ->flush();
}

// shit's getting real at this point

function scenario7_calculated_fields()
{
    throw new \Exception('no idea what this looks like yet');
    // For example let's say on our model we have start and end date and then a number of days field that is the difference between them
    // one may want to be able to set a start and end date and have that field correctly calculated so that tests always make sense
    // without you having to be overly explicit

    // More complex version of this may be when the user wants to be able to do the above OR to set the start date and the number of days and have the end date calculated both on the same configuration - could we handle stuff like that? do we need to be more prescribed
}

function scenario8_example_of_closure_table_hierarchy()
{
    throw new \Exception('no idea what this looks like yet');

    // This is a fairly complex scenario where we are able to say give me a node at depth 5 of the hierarchy
    // or to be able to say give me the root node with 8 children
    // or give me the node 5 deep in the hierarchy with 3 children
    // how do we nicely represent this with the library?
}


// The ones below are questionable as there is a risk they introduce too much complexity for users of the library,
// each of the scenarios could be achieved by working on the related entities rather than allowing more in withData
// if doing this perhaps keep the simple WithDataCommand as is and perhaps have an alternate command
// that is something like WithNestableData - this can then be a configuration option
// Commands would then be created from within builder via factory that could be swapped between
// StrictFeatureFactory (returns WithDataCommand) and FullFeatureFactory (returns WithNestableDataCommand)
// not 100% decided on this, "felt cute, might delete later" as the kids say
function scenario7_relations_in_withData($builder, $otherBuilder)
{
    $otherBuilder->withData(['name' => '1amInNewcastle']);

    $builder
        ->withData(['username' => 'jihad', 'timezone' => $otherBuilder])
        ->withData(['email' => 'jihad@example.com', 'nationality' => 'Geordie'])
        ->flush();
}

function scenario8_relation_lookups_in_withData($builder)
{
    // Creates related builder
    $builder
        ->withData(['username' => 'jihad', 'timezone.name' => '1amInNewcastle'])
        ->withData(['email' => 'jihad@example.com', 'nationality' => 'Geordie'])
        ->flush();
}

function scenario9_relation_in_withData_where_related_entity_already_exists($builder, $otherBuilder)
{
    // Maps 'timezone.name' on to $otherBuilder as that's already been registered
    $builder
        ->relate($otherBuilder, 'timezone')
        ->withData(['username' => 'jihad', 'timezone.name' => '1amInNewcastle'])
        ->withData(['email' => 'jihad@example.com', 'nationality' => 'Geordie'])
        ->flush();
}