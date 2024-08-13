/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret
 * or copyright law. Redistribution of this information or reproduction of this material is
 * strictly forbidden unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from
 * InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

export default function toLocalTime(dateTime: string, format?: boolean): string|Date|undefined {
  if (!dateTime) {
    return undefined;
  }

  let isoDate = dateTime;
  if (isoDate) {
    isoDate = `${isoDate}`.replace(/-/g, '/');

    try {
      const result = new Date(`${isoDate} UTC`);

      if (format) {
        return result.toLocaleString();
      }

      return result;
    } catch (e) {
      try {
        const result2 = new Date(Date.parse(`${isoDate} UTC`));

        if (format) {
          return result2.toLocaleString();
        }

        return result2;
      } catch (ex) {
        // eg phantomjs etc
        const datePart = isoDate.substr(0, 10);
        const timePart = isoDate.substr(11);

        const dateParts = datePart.split('/');
        const timeParts = timePart.split(':');

        if (dateParts.length === 3 && timeParts.length === 3) {
          let result3 = new Date(
            parseInt(dateParts[0], 10),
            parseInt(dateParts[1], 10) - 1,
            parseInt(dateParts[2], 10),
            parseInt(timeParts[0], 10),
            parseInt(timeParts[1], 10),
            parseInt(timeParts[2], 10),
          );

          const newTime = result3.getTime() + (result3.getTimezoneOffset() * 60000);
          result3 = new Date(newTime);

          if (format) {
            return result3.toLocaleString();
          }

          return result3;
        }
      }
    }
  }

  if (format) {
    return '';
  }

  return undefined;
}
