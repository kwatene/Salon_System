using Microsoft.AspNetCore.Mvc;

namespace Salon_System.Controllers
{
    public class BookingController : Controller
    {
        public IActionResult Index()
        {
            return View();
        }
    }
}
