using Microsoft.AspNetCore.Mvc;

namespace Salon_System.Controllers
{
    public class ServicePackController : Controller
    {
        public IActionResult Index()
        {
            return View();
        }
    }
}
