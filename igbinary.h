/*
  +----------------------------------------------------------------------+
  | See COPYING file for further copyright information                   |
  +----------------------------------------------------------------------+ 
  | Author: Oleg Grenrus <oleg.grenrus@dynamoid.com>                     |
  | See CREDITS for contributors                                         |
  +----------------------------------------------------------------------+ 
*/

#ifndef IGBINARY_H
#define IGBINARY_H
#ifdef PHP_WIN32
# include "ig_win32.h"
#else
# include <stdint.h>
#endif
#include "php.h"

#define IGBINARY_VERSION "1.1"

/** Serialize zval.
 * Return buffer is allocated by this function with emalloc.
 * @param[out] ret Return buffer
 * @param[out] ret_len Size of return buffer
 * @param[in] z Variable to be serialized
 * @return 0 on success, 1 elsewhere.
 */
int igbinary_serialize(uint8_t **ret, size_t *ret_len, zval *z TSRMLS_DC);

/** Unserialize to zval.
 * @param[in] buf Buffer with serialized data.
 * @param[in] buf_len Buffer length.
 * @param[out] z Unserialized zval
 * @return 0 on success, 1 elsewhere.
 */
int igbinary_unserialize(const uint8_t *buf, size_t buf_len, zval **z TSRMLS_DC);

#endif /* IGBINARY_H */
