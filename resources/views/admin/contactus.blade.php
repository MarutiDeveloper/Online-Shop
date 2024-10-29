@extends('admin.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="http://localhost/amazing-shop/">Home</a></li>
                <li class="breadcrumb-item">Contact Us</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-10">
    <div class="container">
        <div class="section-title mt-5 ">
            <h2>Love to Hear From You</h2>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-3 pe-lg-5">
                <p>It is a long established fact that a reader will be distracted by the readable content of a page when
                    looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal
                    distribution of letters, as opposed to using Content.</p>
                <address>
                    Cecilia Chapman <br>
                    711-2880 Nulla St.<br>
                    Mankato Mississippi 96522<br>
                    <a href="tel:+xxxxxxxx">(XXX) 555-2368</a><br>
                    <a href="mailto:jim@rock.com">jim@rock.com</a>
                </address>
            </div>

            <div class="col-md-6">
                <form class="shake" role="form" method="POST" id="contactForm" name="contact-form"
                    action="{{ route('admin.contact_us.store') }}">
                    @csrf <!-- CSRF Token for security -->

                    <div class="form-group mb-3">
                        <label for="company_name">Company Name</label>
                        <input type="text" name="company_name" id="company_name" class="form-control" required
                            maxlength="255">
                    </div>
                    <div class="form-group mb-3">
                        <label for="company_address">Company Address</label>
                        <textarea name="company_address" id="company_address" class="form-control" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="company_phone_number">Company Phone Number</label>
                        <input type="text" name="company_phone_number" id="company_phone_number" class="form-control"
                            required maxlength="15">
                    </div>
                    <div class="form-group mb-3">
                        <label for="company_email">Company Email</label>
                        <input type="email" name="company_email" id="company_email" class="form-control" required>
                    </div>

                    <div class="form-submit">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')

@endsection