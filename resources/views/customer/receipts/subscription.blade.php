<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        /* --- General Styles & Fonts --- */
        body {
            font-family: Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            /* White background is best for PDFs */
            margin: 0;
            padding: 20px;
            color: #333;
            font-size: 14px;
        }

        /* --- Main Receipt Container --- */

        .receipt-container {
            margin: 0 auto;
            /* Centering on the page */
            background: #ffffff;
        }


        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .header-table td {
            vertical-align: middle;
            /* Vertically aligns content in the middle of the cell */
            padding-bottom: 20px;
        }

        .header-table td:first-child {
            border-bottom: 2px solid #333;
        }

        .header-table td:last-child {
            text-align: right;
            border-bottom: 2px solid #333;
        }

        .company-info h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .company-info p {
            margin: 150px !important;
            font-size: 13px;
            color: #555;
        }

        .receipt-status {
            padding: 20px !important;
        }

        .status-badge {
            display: inline-block;
            /* background-color: #28a745; */
            padding: 20px !important;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* --- Client & Payment Details Section --- */
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 70px;
        }

        .details-table td {
            width: 50%;
            /* Ensures two equal columns */
            vertical-align: top;
            /* Aligns content to the top */
            padding-right: 20px;
            /* Adds spacing between columns */
        }

        .details-block {
            page-break-inside: avoid;
            /* Prevents this block from being split across pages */
        }

        .details-block h3 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 15px;
        }

        .details-block p {
            margin: 8px 0;
            font-size: 14px;
            line-height: 1.5;
            padding-bottom: 15px;
        }

        .details-block strong {
            display: inline-block;
            min-width: 100px;
        }

        /* --- Itemized Table --- */
        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .receipt-table th {
            background-color: #f8f9fa;
            text-align: left;
            padding: 12px;
            font-weight: bold;
            border-bottom: 2px solid #dee2e6;
        }

        .receipt-table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .receipt-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* IMPORTANT: Prevents table rows from being split across two pages */
        .receipt-table tbody tr {
            page-break-inside: avoid;
        }

        /* --- Financial Summary Section --- */
        .summary-section {
            display: flex;
            justify-content: flex-end;
        }

        .summary-block {
            min-width: 300px;
            text-align: right;
            page-break-inside: avoid;
        }

        .summary-block p {
            margin: 10px 0;
            font-size: 16px;
        }

        .summary-block .total {
            font-size: 20px;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 10px;
        }

        /* --- Footer Section --- */
        .receipt-footer {
            margin-top: 40px;
            text-align: center;
            font-size: 15px;
            color: #888;
            border-top: 1px solid #e0e0e0;
            padding-top: 20px;
        }
    </style>
</head>

<body>

    <div class="receipt-container">
        <!-- Header: Company Info and Status -->
        <table class="header-table">
            <tr>
                <td>
                    <div class="company-info">
                        <img src="https://portal.growthbubbles.com/images/logo.png" alt="" style="height: 50px">
                        <h1>Growth Bubbles Inc.</h1>
                        <p>86-90, Paul Street, London EC2A 4NE</p>
                        <p>hello@growthbubbles.com</p>
                    </div>
                </td>
                <td>
                    <div class="receipt-status">
                        @if ($subscription->invoice->status == 'paid')
                            <div class="status-badge" style="color: green;">
                                <h1>Paid</h1>
                            </div>
                        @else
                            <div class="status-badge" style="color: red;">
                                <h2>Unpaid</h2>
                            </div>
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <!-- Client and Payment Details -->
        <table class="details-table">
            <tr>
                <td>
                    <div class="details-block">
                        <h3>Billed To</h3>
                        <p>&nbsp;</p>
                        <p><strong>Name:</strong>
                            {{ $subscription->customer->last_name . ' ' . $subscription->customer->other_names }}</p>
                        <p>&nbsp;</p>
                        <p><strong>Email:</strong> {{ $subscription->customer->email }}</p>
                        <p>&nbsp;</p>
                        <p><strong>Address:</strong> {{ $subscription->customer->contact_address }}</p>
                    </div>
                </td>
                <td>
                    <div class="details-block">
                        <h3>Payment Information</h3>
                        <p>&nbsp;</p>
                        <p><strong>Receipt No:</strong> {{ $subscription->invoice->invoice_number }}</p>
                        <p>&nbsp;</p>
                        <p><strong>Date Issued:</strong> {{ date_format($subscription->invoice->created_at, 'F j, Y') }}</p>
                        <p>&nbsp;</p>
                        <p><strong>Method:</strong> {{ $subscription->invoice->payment_method }}</p>
                        <p>&nbsp;</p>
                        <p><strong>Transaction ID:</strong> {{ $subscription->invoice->txn_id }}</p>
                    </div>
                </td>
            </tr>
        </table>



        <!-- Itemized List of Services/Products -->
        <section class="item-table-section">
            <table class="receipt-table">
                <thead>
                    <tr>
                        <th>Item Description</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $subscription->name() }}</td>
                        <td>1</td>
                        <td>&pound;{{ number_format($subscription->amount, 2) }}</td>
                        <td style="text-align: right;">&pound;{{ number_format($subscription->pricing, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Financial Summary -->
        <section class="summary-section">
            <div class="summary-block">
                <p>Subtotal: &nbsp;<span style="float: right;">
                        &pound;{{ number_format($subscription->pricing, 2) }}</span>
                </p>
                <p>Tax: &nbsp;<span style="float: right;"> &pound;0.00</span></p>
                <p class="total">Grand Total: &nbsp;<span style="float: right;">
                        &pound;{{ number_format($subscription->pricing, 2) }}</span></p>
            </div>
        </section>

        <!-- Footer -->
        <footer class="receipt-footer">
            <p>&copy; Growth Bubbles Inc.</p>
        </footer>
    </div>

</body>

</html>
