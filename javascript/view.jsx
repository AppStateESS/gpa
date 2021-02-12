'use strict'
import React from 'react'
import ReactDOM from 'react-dom'

var passedData = <?php echo json_encode($data); ?>;

const table = () => {
    var html = `
        <table>
            <tbody>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Banner ID</th>
                    <th>GPA</th>
                    <th>Term</th>
                    <th>Transfer</th>
                    <th>Year</th>
                </tr>`;
    for (var i = 0; i < passedData.length; i++)
    {
        html += `
                <tr>
                    <td>${i.first_name}</td>
                    <td>${i.last_name}</td>
                    <td>${i.banner}</td>
                    <td>${i.gpa}</td>
                    <td>${i.term}</td>
                    <td>${i.transfer}</td>
                    <td>${i.year}</td>
                </tr>`;
    }
    html += `</tbody>
        </table>`;
    return html;
}

ReactDOM.render(<Results />, document.getElementById('Results'));
