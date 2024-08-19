<script>
    $(document).on('click', 'a.generate-report', function () {

        var newWin = open('', 'windowName', 'height=1000,width=1000');
        let con = '';

        let header = '<div class="header">\
                        <h3>WORKERS HIRED IN INFRASTRACTURE PROJECTS (WHIP) MONITORING </h3>\
                        <h5>Legal Basis : City Ordinance No. 868-2020 and Republic Act No. 6685</h5>\
                    </div>';

        let table =  '<table class="table table-hover table-striped "  style="width: 100%;" >\
              <tr>\
                <td style="width: 23%;">Project Title</td>\
                <td ><span class="tb">Construction of Hospital</span></td>\
            </tr>\
             <tr>\
                <td>Contractor</td>\
                <td ><span class="tb">DDS Builder</span></td>\
            </tr>\
             <tr>\
                <td>Project Location</td>\
                <td ><span >DDS Builder</span></td>\
            </tr>\
             <tr>\
                <td>Project Nature</td>\
                <td ><span >DDS Builder</span></td>\
            </tr>\
             <tr>\
                <td>Project Cost</td>\
                <td ><span >DDS Builder</span></td>\
            </tr>\
              <tr>\
                <td>Date Started</td>\
                <td ><span >DDS Builder</span></td>\
            </tr>\
              <tr>\
                <td>Date of Monitoring</td>\
                <td ><span >DDS Builder</span></td>\
            </tr>\
              <tr>\
                <td>Specific Activity</td>\
                <td ><span >DDS Builder</span></td>\
            </tr>\
        </table>';

        let header2 =  '<div class="header" style="margin-top: 20px;">\
                        <h3>RESULT / FINDINGS FROM THE MONITORING</h3>\
                    </div>';

        let header3=  '<div class="heade3" style="margin-top: 20px;">\
                        <h3>A. MANDATORY REQUIREMENT OF 30% IN HIRING SKILLED WORKERS</h3>\
                    </div>';

        let table2 = '<table class="table table-hover table-striped table-information "  >\
              <tr>\
                <th>DESCRIPTION</th>\
                <th>SKILLED</th>\
                <th>%-Age</th>\
                <th>IMPRESSION</th>\
            </tr>\
             <tr>\
                <th>Actual No. of Hired Workers</th>\
                <th>7</th>\
                <th>100%</th>\
                <th rowspan="3">COMPLIANT</th>\
            </tr>\
             <tr>\
                <td>No. of Workers Hired Outside Oroquieta</td>\
                <td>0</td>\
                <td>0</td>\
            </tr>\
              <tr>\
                <td>No. of Workers Hired Within Oroquieta</td>\
                <td>0</td>\
                <td>0</td>\
            </tr>\
             <tr>\
                <th>Actual No. of Workers Within Project</th>\
                <th>7</th>\
                <th>100%</th>\
                <th rowspan="3">NON-COMPLIANT</th>\
            </tr>\
              <tr>\
                <td>No. of Workers Hired From Nearby Brgy.</td>\
                <td>0</td>\
                <td>0</td>\
            </tr>\
             <tr>\
                <td>No. of Workers Hired From Far Brgys.</td>\
                <td>0</td>\
                <td>0</td>\
            </tr>\
        </table>';
        
        con += '<!DOCTYPE html>\
                       <html>\
                          <head>\
                             <title>Print</title>\
                             <link href="{{asset("lls_assets/css/whip_report.css")}}" rel="stylesheet">\
                          </head>\
                          <body>';
        let header4 =  '<div class="heade3" style="margin-top: 20px;">\
                        <h3>B. MANDATORY REQUIREMENT OF 50% IN HIRING UNSKILLED WORKERS</h3>\
                    </div>';  
        let table3 = '<table class="table table-hover table-striped table-information "  >\
              <tr>\
                <th>DESCRIPTION</th>\
                <th>SKILLED</th>\
                <th>%-Age</th>\
                <th>IMPRESSION</th>\
            </tr>\
             <tr>\
                <th>Actual No. of Hired Workers</th>\
                <th>7</th>\
                <th>100%</th>\
                <th rowspan="3">COMPLIANT</th>\
            </tr>\
             <tr>\
                <td>No. of Workers Hired Outside Oroquieta</td>\
                <td>0</td>\
                <td>0</td>\
            </tr>\
              <tr>\
                <td>No. of Workers Hired Within Oroquieta</td>\
                <td>0</td>\
                <td>0</td>\
            </tr>\
             <tr>\
                <th>Actual No. of Workers Within Project</th>\
                <th>7</th>\
                <th>100%</th>\
                <th rowspan="3">NON-COMPLIANT</th>\
            </tr>\
              <tr>\
                <td>No. of Workers Hired From Nearby Brgy.</td>\
                <td>0</td>\
                <td>0</td>\
            </tr>\
             <tr>\
                <td>No. of Workers Hired From Far Brgys.</td>\
                <td>0</td>\
                <td>0</td>\
            </tr>\
        </table>';   
        let bottom = '<div class="impression"><span>OVER-ALL IMPRESSION</span><span>________________________________________</span></div>';             
        con += '<div class="container">';
        con += header;
        con += table; 
        con += header2;
        con += header3;
        con += table2;
        con += header4;
        con += table3;
        con += bottom;
        con += '  </div></body></html>';
        newWin.document.write(con);
        setTimeout(() => {
           newWin.print();
        }, 1000);
    });

</script>