export const  convertMysqlDateFormat = (dateString) => {
    // Parse the given date string into a Date object
    const date = new Date(dateString);
    // Define months array for mapping
    const months = [
        "January", "February", "March",
        "April", "May", "June",
        "July", "August", "September",
        "October", "November", "December"
    ];

    // Extract year, month, and day
    const year = date.getFullYear();
    const monthIndex = date.getMonth();
    const day = date.getDate();

    // Format the date string in desired format
    const formattedDate = `${months[monthIndex]}, ${day}, ${year}`;

    return formattedDate;
}