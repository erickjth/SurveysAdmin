function showMessage(message,header,theme){

    if(theme = "")
        theme =  "info-notification";
    
    $.jGrowl(message,
    {
        header: header,
        theme: theme
    }
    );
}