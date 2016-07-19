<?php

echo 'welcome jie!';

$servername = "localhost";
$username = "root";
$password = "susie19910401";
$dbname = "linx_family";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$families = "select * from family;";
$result_families = $conn->query($families);

if ($result_families->num_rows > 0) {

    // traverse all the family
    while ($family = $result_families->fetch_assoc()) {

        echo " <h2> family name " . $family["family_name"] . "</h2>";

        // get root parents of this family
        $root_parents = "select person.person_id, last_name, first_name from parents, person " .
            "where parents.parents_id = " . $family["parents_id"] . " AND (parents.dad=person.person_id OR parents.mom=person.person_id)";
        $result_root_parents = $conn->query($root_parents);

        // saves all the parents, or people who has children(may single), of a level(or to say generation)
        $parents_ids = array();
        array_push($parents_ids, $family["parents_id"]);

        echo " Wish my ancestors <br>";

        if ($result_root_parents->num_rows > 0) {

            // first level of parents whose ancestor will not be shown
            while ($root = $result_root_parents->fetch_assoc()) {
                echo "id " . $root["person_id"] . " name " . $root["last_name"] . " " . $root["first_name"] . "   ";
            }
            echo "<br> root parents end <br>";

            $level = 1;
            // bfs starts here
            // get all the children
            while (count($parents_ids) > 0) {

                echo "<h3> generation " . $level . "</h3>";

                // fix the size before loop a level
                $parent_size = count($parents_ids);

                while ($parent_size > 0) {

                    // get the first parent of the previous generation
                    $curr_parent_id = array_shift($parents_ids);

                    // get the children of that parent
                    $children = "select * from person where parents_id = " . $curr_parent_id;
                    $result_children = $conn->query($children);

                    // we will see if the children is single or has married (if married, there will be a new parents)
                    while ($child = $result_children->fetch_assoc()) {

                        // check if we can find this child's spouse
                        $current_parent_id = $child["person_id"];
                        // check if this child is single TT
                        $parent = "select * from parents where dad=" . $current_parent_id . " OR mom=" . $current_parent_id;
                        $result_parent = $conn->query($parent);

                        if ($result_parent->num_rows > 0) {

                            // this child has a spouse, we out put this new parents
                            while ($new_parent = $result_parent->fetch_assoc()) {
                                array_push($parents_ids, $new_parent["parents_id"]);
                                // show
                                echo " <br> ";
                                echo "parent id = " . $new_parent["parents_id"];

                                if ($new_parent["dad"] === $current_parent_id) {
                                    echo " dad person_id = " . $new_parent["dad"] . " his parent is " . $curr_parent_id;
                                    echo " ---- mom person_id = " . $new_parent["mom"];
                                } else {
                                    echo " dad person_id = " . $new_parent["dad"];
                                    echo " ---- mom person_id = " . $new_parent["mom"] . " her parent is " . $curr_parent_id;
                                }

                                echo " <br> ";
                            }
                        } else {

                            // this child is still single or do not have child
                            echo " <br> ";
                            echo "single person_id = " . $child["person_id"] . " parent_id = " . $curr_parent_id;
                            echo " <br> ";
                        }
                    }

                    //
                    $parent_size--;

                }

                echo "<h3> generation " . $level++ . " end </h3>";
            }
        } else {
            echo "no one is in this family...";
        }
    }

} else {

    echo "no families now..";
}

?>