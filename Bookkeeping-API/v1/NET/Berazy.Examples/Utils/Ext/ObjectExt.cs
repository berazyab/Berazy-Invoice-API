using System;

namespace Berazy.Examples.Utils.Ext {

    internal static class ObjectExt {

        /// <summary>
        /// Checks if an item is null
        /// </summary>
        /// <param name="data">The item to check for nullity.</param>
        public static bool IsNull<T>(this T data) where T : class {
            return data == null;
        }

        /// <summary>
        /// Checks if an item is not null
        /// </summary>
        /// <param name="data">The item to check for nullity.</param>
        public static bool IsNotNull<T>(this T data) where T : class {
            return data != null;
        }

        /// <summary>
        /// Throws an ArgumentNullException if the given data item is null.
        /// </summary>
        /// <param name="data">The item to check for nullity.</param>
        public static void ThrowIfNull<T>(this T data) where T : class {
            if (data == null) {
                throw new ArgumentNullException();
            }
        }

    }

}
