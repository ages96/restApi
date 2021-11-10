@include('mail.header')
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td style="padding: 10px 60px 10px 60px;"> 
                        {{ $data["title"] }}
                    </td>
                </tr>
            </tbody>
        </table>
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td style="padding: 10px 60px 10px 60px;"> 
                        {{ $data["description"] }}
                    </td>
                </tr>
            </tbody>
        </table>
@include('mail.footer')