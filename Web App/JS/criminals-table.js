// Data is temporary, need to be able to retrieve data from DB
// replace dummy_data with a proper variable name at some point
var dummy_data = [
    [1, 'Smith', 'John', '123 Main St', 'New York', 'NY', 12345, 123456789, 'y', 'n'],
    [2, 'Johnson', 'Edward', '456 Oak St', 'Flushing', 'NY', 15485, 234567890, 'n', 'y'],
    [3, 'Leonard', 'Mike', '789 Maple Ave', 'Jamaica', 'NY', 12923, 345678901, 'y', 'y'],
    [4, 'Gibson', 'Carlos', '321 Elm St', 'Astoria', 'NY', 98765, 456789012, 'n', 'n'],
    [5, 'Kim', 'Jeremy', '654 Pine St', 'Newark', 'NJ', 43210, 567890123, 'y', 'y'],
    [6, 'Joseph', 'David', '987 Cedar Blvd', 'Trenton', 'NJ', 56789, 678901234, 'n', 'y'],
    [7, 'Wilson', 'Gary', '246 Walnut Ave', 'Philadelphia', 'PA', 75421, 789012345, 'y', 'n'],
    [8, 'Doe', 'Anthony', '135 Oak St', 'Pittsburgh', 'PA', 23532, 890123456, 'n', 'n'],
    [9, 'Nelson', 'Mike', '864 Elm St', 'Orlando', 'FL', 91293, 901234567, 'y', 'y'],
    [10, 'Martin', 'Andy', '123 Pine St', 'Miami', 'FL', 33542, 789012345, 'n', 'y']
];

var table = document.getElementById("Criminals");

for (var i = 0; i < dummy_data.length; i++) {
    // add new row
    var row = table.insertRow(i + 1);
    var cell0 = row.insertCell(0); // c_id
    var cell1 = row.insertCell(1); // c_last
    var cell2 = row.insertCell(2); // c_first
    var cell3 = row.insertCell(3); // c_street
    var cell4 = row.insertCell(4); // c_city
    var cell5 = row.insertCell(5); // c_state
    var cell6 = row.insertCell(6); // c_zip
    var cell7 = row.insertCell(7); // c_phone_num
    var cell8 = row.insertCell(8); // V_status
    var cell9 = row.insertCell(9); // P_status

    cell0.innerHTML =  dummy_data[i][0]; 
    cell1.innerHTML =  dummy_data[i][1]; 
    cell2.innerHTML =  dummy_data[i][2]; 
    cell3.innerHTML =  dummy_data[i][3]; 
    cell4.innerHTML =  dummy_data[i][4];
    cell5.innerHTML =  dummy_data[i][5];
    cell6.innerHTML =  dummy_data[i][6];
    cell7.innerHTML =  dummy_data[i][7];

    // For readability
    if(dummy_data[i][8] == "y") {
        cell8.innerHTML = "yes"
    }
    if(dummy_data[i][8] == "n") {
        cell8.innerHTML = "no"
    }
    if(dummy_data[i][9] == "y") {
        cell9.innerHTML = "yes"
    }
    if(dummy_data[i][9] == "n") {
        cell9.innerHTML = "no"
    }
}