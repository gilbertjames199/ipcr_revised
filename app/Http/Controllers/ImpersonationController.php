<?php

namespace Lab404\Impersonate\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Lab404\Impersonate\Services\ImpersonateManager;

class ImpersonateController extends Controller
{
    /** @var ImpersonateManager */
    protected $manager;

    /**
     * ImpersonateController constructor.
     */
    public function __construct()
    {
        $this->manager = app()->make(ImpersonateManager::class);

        $guard = $this->manager->getDefaultSessionGuard();
        $this->middleware('auth:' . $guard)->only('take');
    }

    /**
     * @param int         $id
     * @param string|null $guardName
     * @return  RedirectResponse
     * @throws  \Exception
     */
    public function take(Request $request, $id, $guardName = null)
    {
        // dd($id);
        session(['impersonating' => true]);
        // if (session()->has('impersonating')) {
        //     // $request->attributes->set('impersonating', true);
        //     dd('is impersonating');
        // } else {
        //     dd('no');
        // }
        $guardName = $guardName ?? $this->manager->getDefaultSessionGuard();
        // dd($this->manager->getDefaultSessionGuard());

        // Cannot impersonate yourself
        if ($id == $request->user()->getAuthIdentifier() && ($this->manager->getCurrentAuthGuardName() == $guardName)) {
            // abort(403);
            return redirect()->back()->with('error', 'You cannot impersonate yourself');
        }

        // Cannot impersonate again if you're already impersonate a user
        if ($this->manager->isImpersonating()) {
            // abort(403);
            return redirect()->back()->with('error', 'You cannot impersonate again if you\'re already impersonating a user');
        }
        // dd($request->user()->canImpersonate());
        if (!$request->user()->canImpersonate()) {
            // abort(403);
            return redirect()->back()->with('error', 'You cannot impersonate again if you\'re already impersonating a user');
        }

        $userToImpersonate = $this->manager->findUserById($id, $guardName);
        // dd($userToImpersonate->canBeImpersonated());
        // if ($userToImpersonate->canBeImpersonated()) {
        if ($userToImpersonate->canBeImpersonated()) {
            if ($this->manager->take($request->user(), $userToImpersonate, $guardName)) {
                $takeRedirect = $this->manager->getTakeRedirectTo();
                if ($takeRedirect !== 'back') {
                    return redirect()->to($takeRedirect);
                }
            }
        }

        return redirect()->back();
    }

    /**
     * @return RedirectResponse
     */
    public function leave()
    {
        session(['impersonating' => false]);
        if (!$this->manager->isImpersonating()) {
            abort(403);
        }

        $this->manager->leave();

        $leaveRedirect = $this->manager->getLeaveRedirectTo();
        if ($leaveRedirect !== 'back') {
            return redirect('employees/all');
            // return redirect()->to($leaveRedirect);
        }
        return redirect('employees/all');
        // return redirect()->back();
    }
}
