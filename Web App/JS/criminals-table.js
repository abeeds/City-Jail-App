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
    var row = table.insertRow(i + 1);

    for (var j = 0; j < dummy_data[i].length; j++) {
        var cell = row.insertCell(j);
        
        if(j == 8 || j == 9) {
            if(dummy_data[i][j] == "y") {
                cell.innerHTML = "Yes";
            }
            if(dummy_data[i][j] == "n") {
                cell.innerHTML = "No";
            }
        }
        else {
            cell.innerHTML = dummy_data[i][j];
        }
    }
}