<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Testimonial Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #9229AD;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            border: 1px solid #ddd;
            border-top: none;
            padding: 20px;
            border-radius: 0 0 5px 5px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        table td:first-child {
            font-weight: bold;
            width: 30%;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>New Testimonial Request Submitted</h2>
    </div>
    
    <div class="content">
        <p>A new testimonial request has been submitted for your review.</p>
        
        <table>
            <tr>
                <td>Project:</td>
                <td>{{ $testimonial->project->title }}</td>
            </tr>
            <tr>
                <td>Requested By:</td>
                <td>{{ $testimonial->requester->name }}</td>
            </tr>
            <tr>
                <td>Title:</td>
                <td>{{ $testimonial->title }}</td>
            </tr>
            <tr>
                <td>Description:</td>
                <td>{{ $testimonial->description }}</td>
            </tr>
            <tr>
                <td>Date Submitted:</td>
                <td>{{ is_string($testimonial->date) ? $testimonial->date : $testimonial->date->format('F j, Y') }}</td>
            </tr>
            <tr>
                <td>Status:</td>
                <td>{{ ucfirst($testimonial->status) }}</td>
            </tr>
        </table>
        
        <p style="margin-top: 20px;">
            <a href="{{ route('projects.show', $testimonial->project_id) }}" style="background-color: #9229AD; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block;">
                View Project Details
            </a>
        </p>
    </div>
    
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
    </div>
</body>
</html> 