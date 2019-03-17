// Calkowanie numeryczne - metoda trapezow
// www.algorytm.org
// (c)2007 by Tomasz Lubinski


using System;

namespace metoda_trapezow_cs
{
    /// <summary>
    /// Summary description for Class1.
    /// </summary>
    class Metoda_trapezow
    {
        public delegate double FUNC(double x);

        /// <summary>
        /// Oblicza calke metoda trapezow w przedziale od xp do xk z dokladnoscia n dla funkcji fun
        /// </summary>
        /// <param name="xp">poczatek przedzialu calkowania</param>
        /// <param name="xk">koniec przedzialu calkowania</param>
        /// <param name="n">dokladnosc calkowania</param>
        /// <param name="func">funkcja calkowana</param>
        /// <returns></returns>
        private static double calculate(double xp, double xk, int n, FUNC func)
        {
            double h, calka,calka1;

            h = (xk - xp) / (double)n;

            calka1 = 0;
            for (int i = 1; i < n; i++)
            {
                calka1 += func(xp + i * h);
            }
            calka1 += (func(xp) + func(xk)) / 2;
            calka1 *= h;

            h = (xk - xp) / (double)n;

            calka = 0;
            for (int i = 1; i < n; i++)
            {
                calka +=((func(xp + i * h) + func(xp + (i + 1) * h)) / 2)*h;
            }
           
           

            return calka1;
        }

        //funkcja dla ktorej obliczamy calke
        private static double func(double x)
        {
            return x * x + 3;
        }

        /// <summary>
        /// The main entry point for the application.
        /// </summary>
        [STAThread]
        static void Main(string[] args)
        {
            double xp, xk;
            int n;
            FUNC function = new FUNC(func);

            Console.WriteLine("Podaj poczatek przedzialu calkowania");
            xp = 0;//double.Parse(Console.ReadLine());

            Console.WriteLine("Podaj koniec przedzialu calkowania");
            xk = 9;

            Console.WriteLine("Podaj dokladnosc calkowania");
            n = 8;

            Console.WriteLine("Wartosc clki wynosi w przyblizeniu " + calculate(xp, xk, n, function));
            Console.ReadLine();
        }
    }
}